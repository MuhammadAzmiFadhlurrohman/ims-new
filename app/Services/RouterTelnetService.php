<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class RouterTelnetService
{
    protected $socket = null;
    protected int $timeout = 4;
    protected string $buffer = '';

    /**
     * Connect and authenticate via Telnet to MikroTik RouterOS
     */
    public function connect(string $host, int $port = 23, string $username = 'admin', string $password = '', int $timeout = 4): array
    {
        $this->timeout = $timeout;
        $startTime = microtime(true);

        $fp = @fsockopen($host, $port, $errno, $errstr, $this->timeout);
        if (!$fp) {
            return [
                'success' => false,
                'message' => "Gagal membuka socket Telnet ke {$host}:{$port}. ({$errstr} [{$errno}])",
                'latency' => null,
            ];
        }

        $this->socket = $fp;
        stream_set_timeout($this->socket, $this->timeout);
        stream_set_blocking($this->socket, true);

        // MikroTik Telnet Login flow
        // username+ct disables colors and terminal pause / more pagination in MikroTik RouterOS!
        $loginUser = $username;
        if (!str_contains($loginUser, '+')) {
            $loginUser .= '+ct500w500';
        }

        try {
            // 1. Wait for "Login: " or "user: "
            $prompt = $this->readUntil(['Login:', 'login:', 'User:', 'user:'], 4);
            if ($prompt === false) {
                // If direct login prompt not matched, check if already asking password or banner
                if (!str_contains($this->buffer, 'Login') && !str_contains($this->buffer, 'login')) {
                    $this->write($loginUser);
                } else {
                    $this->write($loginUser);
                }
            } else {
                $this->write($loginUser);
            }

            // 2. Wait for "Password: "
            $pwPrompt = $this->readUntil(['Password:', 'password:'], 4);
            $this->write($password);

            // 3. Wait for Router prompt ">"
            $cliPrompt = $this->readUntil(['>', '#'], 4);
            if ($cliPrompt === false) {
                // Check if login failed
                if (str_contains($this->buffer, 'Login failed') || str_contains($this->buffer, 'invalid')) {
                    $this->disconnect();
                    return [
                        'success' => false,
                        'message' => "Autentikasi Telnet Gagal: Username atau Password MikroTik salah.",
                        'latency' => null,
                    ];
                }
            }

            $duration = round((microtime(true) - $startTime) * 1000, 2);

            return [
                'success' => true,
                'message' => "Telnet berhasil terhubung ke {$host}:{$port} ({$duration} ms).",
                'latency' => $duration,
            ];
        } catch (\Throwable $e) {
            $this->disconnect();
            return [
                'success' => false,
                'message' => "Error saat negosiasi Telnet: " . $e->getMessage(),
                'latency' => null,
            ];
        }
    }

    /**
     * Send command and return output text
     */
    public function exec(string $command): string
    {
        if (!$this->socket) {
            return '';
        }

        $this->buffer = '';
        $this->write($command);
        $this->readUntil(['>', '#'], $this->timeout);

        // Clean out echo command and prompt from output
        $clean = preg_replace('/^\s*' . preg_quote($command, '/') . '\s*/i', '', $this->buffer);
        $clean = preg_replace('/\[[^\]]+\]\s*[>#]\s*$/', '', $clean);
        return trim($clean);
    }

    /**
     * Fetch complete system info and PPP profiles via Telnet CLI commands
     */
    public function getSystemInfo(string $host, int $port = 23, string $username = 'admin', string $password = ''): array
    {
        $conn = $this->connect($host, $port, $username, $password, 4);
        if (!$conn['success']) {
            return [
                'connected' => false,
                'error' => $conn['message'],
            ];
        }

        try {
            // 1. Identity
            $identityRaw = $this->exec('/system identity print');
            $identity = $this->parseSingleField($identityRaw, 'name') ?: 'MikroTik';

            // 2. Resource
            $resRaw = $this->exec('/system resource print');
            $res = $this->parseKeyValuePairs($resRaw);

            // 3. Routerboard
            $rbRaw = $this->exec('/system routerboard print');
            $rb = $this->parseKeyValuePairs($rbRaw);

            // 4. PPP Profile print detail
            $profilesRaw = $this->exec('/ppp profile print detail');
            $profiles = $this->parsePppProfiles($profilesRaw);

            // 5. Active PPP count
            $activeRaw = $this->exec('/ppp active print count-only');
            $activeCount = 0;
            if (is_numeric(trim($activeRaw))) {
                $activeCount = (int) trim($activeRaw);
            } else {
                $activeListRaw = $this->exec('/ppp active print');
                $lines = array_filter(explode("\n", $activeListRaw));
                $activeCount = max(0, count($lines) - 2);
            }

            $this->disconnect();

            return [
                'connected' => true,
                'protocol' => 'Telnet (CLI)',
                'identity' => $identity,
                'board_name' => $res['board-name'] ?? ($rb['model'] ?? 'Mikrotik RouterOS'),
                'version' => $res['version'] ?? '-',
                'uptime' => $res['uptime'] ?? '-',
                'cpu_load' => isset($res['cpu-load']) ? $res['cpu-load'] . (str_ends_with($res['cpu-load'], '%') ? '' : '%') : '0%',
                'cpu_count' => $res['cpu-count'] ?? 1,
                'cpu' => $res['cpu'] ?? '-',
                'cpu_frequency' => isset($res['cpu-frequency']) ? $res['cpu-frequency'] : '-',
                'memory_total' => $res['total-memory'] ?? '-',
                'memory_free' => $res['free-memory'] ?? '-',
                'hdd_total' => $res['total-hdd-space'] ?? '-',
                'hdd_free' => $res['free-hdd-space'] ?? '-',
                'serial_number' => $rb['serial-number'] ?? '-',
                'firmware' => $rb['current-firmware'] ?? ($rb['upgrade-firmware'] ?? '-'),
                'profiles' => $profiles,
                'active_count' => $activeCount,
            ];
        } catch (\Throwable $e) {
            $this->disconnect();
            return [
                'connected' => false,
                'error' => "Error saat parsing data Telnet: " . $e->getMessage(),
            ];
        }
    }

    /**
     * Parse single field like "name: MikroTik"
     */
    protected function parseSingleField(string $raw, string $field): ?string
    {
        if (preg_match('/' . preg_quote($field, '/') . ':\s*([^\r\n]+)/i', $raw, $m)) {
            return trim($m[1]);
        }
        return null;
    }

    /**
     * Parse multi-line key-value pairs (e.g. from `/system resource print`)
     */
    protected function parseKeyValuePairs(string $raw): array
    {
        $data = [];
        $lines = explode("\n", $raw);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            // Pattern: key: value  key2: value2
            if (preg_match_all('/([a-z0-9\-_]+):\s*([^:]+?)(?=(?:\s+[a-z0-9\-_]+:|$))/i', $line, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $m) {
                    $k = trim($m[1]);
                    $v = trim($m[2]);
                    $data[$k] = $v;
                }
            }
        }
        return $data;
    }

    /**
     * Parse PPP profile detailed output into structured array
     */
    protected function parsePppProfiles(string $raw): array
    {
        $profiles = [];
        $blocks = preg_split('/(?=\s*\d+\s+(?:name|default|\*))/i', $raw);

        foreach ($blocks as $block) {
            $block = trim($block);
            if (empty($block)) continue;

            $kv = $this->parseKeyValuePairs($block);
            if (!empty($kv['name'])) {
                $profiles[] = [
                    'name' => $kv['name'] ?? '-',
                    'rate-limit' => $kv['rate-limit'] ?? ($kv['rate'] ?? '-'),
                    'local-address' => $kv['local-address'] ?? '-',
                    'remote-address' => $kv['remote-address'] ?? '-',
                ];
            }
        }

        // If block parse didn't match, try standard regex for profile names
        if (empty($profiles)) {
            preg_match_all('/name="?([^"\s\r\n]+)"?/i', $raw, $names);
            if (!empty($names[1])) {
                foreach (array_unique($names[1]) as $n) {
                    $profiles[] = [
                        'name' => $n,
                        'rate-limit' => '-',
                        'local-address' => '-',
                        'remote-address' => '-',
                    ];
                }
            }
        }

        return $profiles;
    }

    /**
     * Write string with Telnet newline
     */
    protected function write(string $data): void
    {
        if ($this->socket) {
            fwrite($this->socket, $data . "\r\n");
            usleep(150000); // 150ms buffer
        }
    }

    /**
     * Read from socket handling Telnet IAC bytes until one of tokens appears
     */
    protected function readUntil(array $tokens, int $timeoutSec = 4)
    {
        if (!$this->socket) {
            return false;
        }

        $this->buffer = '';
        $startTime = time();

        while (!feof($this->socket) && (time() - $startTime) < $timeoutSec) {
            $char = fgetc($this->socket);
            if ($char === false) {
                usleep(50000);
                continue;
            }

            // Handle Telnet IAC (0xFF) negotiation
            if (ord($char) === 255) {
                $cmd = ord(fgetc($this->socket));
                $opt = ord(fgetc($this->socket));

                // Reply WONT (252) or DONT (254) to all requests
                if ($cmd === 251 || $cmd === 252) { // WILL / WONT
                    fwrite($this->socket, chr(255) . chr(254) . chr($opt)); // DONT
                } elseif ($cmd === 253 || $cmd === 254) { // DO / DONT
                    fwrite($this->socket, chr(255) . chr(252) . chr($opt)); // WONT
                }
                continue;
            }

            $this->buffer .= $char;

            foreach ($tokens as $token) {
                if (str_contains($this->buffer, $token)) {
                    return $token;
                }
            }
        }

        return false;
    }

    /**
     * Disconnect and close socket
     */
    public function disconnect(): void
    {
        if ($this->socket) {
            try {
                @fwrite($this->socket, "/quit\r\n");
                @fclose($this->socket);
            } catch (\Throwable $e) {}
            $this->socket = null;
        }
    }

    public function __destruct()
    {
        $this->disconnect();
    }
}
