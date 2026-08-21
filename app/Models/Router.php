<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Router extends Model
{
    use HasFactory;

    protected $table = 'routers';

    protected $fillable = [
        'name',
        'ip_address',
        'port',
        'username',
        'password',
        'use_ssl',
        'pop_code',
        'model',
        'ros_version',
        'status',
        'last_connected_at',
        'description',
        'is_active',
    ];

    protected $casts = [
        'port' => 'integer',
        'use_ssl' => 'boolean',
        'is_active' => 'boolean',
        'last_connected_at' => 'datetime',
    ];

    public function pop(): BelongsTo
    {
        return $this->belongsTo(Pop::class, 'pop_code', 'code');
    }

    /**
     * Test connection to the Router (Socket ping / API / Telnet check)
     */
    public function testConnection(): array
    {
        $host = $this->ip_address;
        $port = (int) ($this->port ?: 8728);
        $timeout = 3; // seconds

        $startTime = microtime(true);
        $fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
        $duration = round((microtime(true) - $startTime) * 1000, 2);

        if ($fp) {
            fclose($fp);
            $this->update([
                'status' => 'online',
                'last_connected_at' => now(),
            ]);

            $protocolLabel = ($port === 23) ? 'Telnet' : (($port === 8728 || $port === 8729) ? 'RouterOS API' : "Port {$port}");

            return [
                'success' => true,
                'message' => "Koneksi berhasil! Router merespons protokol {$protocolLabel} di port {$port} ({$duration} ms).",
                'latency' => $duration,
            ];
        }

        // If configured port failed and is not 23, attempt Telnet (port 23) fallback check
        if ($port !== 23) {
            $telnetFp = @fsockopen($host, 23, $tErrno, $tErrstr, 2);
            if ($telnetFp) {
                fclose($telnetFp);
                $duration = round((microtime(true) - $startTime) * 1000, 2);
                $this->update([
                    'status' => 'online',
                    'last_connected_at' => now(),
                ]);

                return [
                    'success' => true,
                    'message' => "Port {$port} tidak merespons, namun Telnet (Port 23) TERBUKA dan merespons ({$duration} ms)!",
                    'latency' => $duration,
                ];
            }
        }

        $this->update([
            'status' => 'offline',
        ]);

        return [
            'success' => false,
            'message' => "Gagal terhubung ke {$host}:{$port}. ({$errstr} [{$errno}]). Pastikan IP router dan service API (8728) atau Telnet (23) di MikroTik aktif.",
            'latency' => null,
        ];
    }

    /**
     * Get RouterOS API Client instance (Supports v7 and v6 legacy MD5 authentication)
     */
    public function getClient(bool $legacy = false): ?\RouterOS\Client
    {
        try {
            return new \RouterOS\Client([
                'host' => $this->ip_address,
                'user' => $this->username ?: 'admin',
                'pass' => $this->password ?? '',
                'port' => (int) ($this->port ?: 8728),
                'ssl'  => (bool) ($this->use_ssl ?? false),
                'timeout' => 3,
                'legacy' => $legacy,
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::info("RouterOS API connect [{$this->name}] legacy=" . ($legacy ? '1' : '0') . " failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get PPP Profiles from Router (Live query via API / Telnet)
     */
    public function getPppProfiles(): array
    {
        $defaultProfiles = [
            'default' => 'default',
            'default-encryption' => 'default-encryption',
            'PROFILE-10M' => 'PROFILE 10 Mbps',
            'PROFILE-20M' => 'PROFILE 20 Mbps',
            'PROFILE-30M' => 'PROFILE 30 Mbps',
            'PROFILE-50M' => 'PROFILE 50 Mbps',
            'PROFILE-100M' => 'PROFILE 100 Mbps',
        ];

        // 1. Try API (v7 then v6 legacy)
        foreach ([false, true] as $isLegacy) {
            try {
                $client = $this->getClient($isLegacy);
                if ($client) {
                    $query = new \RouterOS\Query('/ppp/profile/print');
                    $response = $client->query($query)->read();
                    if (is_array($response) && count($response) > 0) {
                        $profiles = [];
                        foreach ($response as $p) {
                            if (!empty($p['name'])) {
                                $profiles[$p['name']] = $p['name'] . (!empty($p['rate-limit']) ? " ({$p['rate-limit']})" : '');
                            }
                        }
                        if (!empty($profiles)) {
                            return $profiles;
                        }
                    }
                }
            } catch (\Throwable $e) {}
        }

        // 2. Try Telnet
        try {
            $telnetService = new \App\Services\RouterTelnetService();
            $info = $telnetService->getSystemInfo($this->ip_address, ($this->port === 23 ? 23 : 23), $this->username ?: 'admin', $this->password ?? '');
            if (!empty($info['profiles'])) {
                $profiles = [];
                foreach ($info['profiles'] as $p) {
                    if (!empty($p['name'])) {
                        $profiles[$p['name']] = $p['name'] . (!empty($p['rate-limit']) && $p['rate-limit'] !== '-' ? " ({$p['rate-limit']})" : '');
                    }
                }
                if (!empty($profiles)) {
                    return $profiles;
                }
            }
        } catch (\Throwable $e) {}

        return $defaultProfiles;
    }

    /**
     * Create or Update PPPoE Secret on MikroTik Router
     */
    public function createPppSecret(
        string $username,
        string $password,
        ?string $profile = null,
        ?string $localAddress = null,
        ?string $remoteAddress = null,
        ?string $comment = null
    ): array {
        // Try API (Modern and Legacy v6)
        foreach ([false, true] as $isLegacy) {
            try {
                $client = $this->getClient($isLegacy);
                if ($client) {
                    $checkQuery = (new \RouterOS\Query('/ppp/secret/print'))
                        ->where('name', $username);
                    $existing = $client->query($checkQuery)->read();

                    if (!empty($existing) && is_array($existing) && count($existing) > 0) {
                        $secretId = $existing[0]['.id'] ?? $username;
                        $updateQuery = (new \RouterOS\Query('/ppp/secret/set'))
                            ->equal('.id', $secretId)
                            ->equal('password', $password)
                            ->equal('service', 'pppoe');

                        if ($profile) $updateQuery->equal('profile', $profile);
                        if ($localAddress) $updateQuery->equal('local-address', $localAddress);
                        if ($remoteAddress) $updateQuery->equal('remote-address', $remoteAddress);
                        if ($comment) $updateQuery->equal('comment', $comment);

                        $client->query($updateQuery)->read();

                        return [
                            'success' => true,
                            'message' => "PPPoE Secret [{$username}] berhasil diperbarui di MikroTik {$this->name}!",
                        ];
                    }

                    $addQuery = (new \RouterOS\Query('/ppp/secret/add'))
                        ->equal('name', $username)
                        ->equal('password', $password)
                        ->equal('service', 'pppoe');

                    if ($profile) $addQuery->equal('profile', $profile);
                    if ($localAddress) $addQuery->equal('local-address', $localAddress);
                    if ($remoteAddress) $addQuery->equal('remote-address', $remoteAddress);
                    if ($comment) $addQuery->equal('comment', $comment);

                    $client->query($addQuery)->read();

                    return [
                        'success' => true,
                        'message' => "PPPoE Secret [{$username}] berhasil dibuat di MikroTik {$this->name}!",
                    ];
                }
            } catch (\Throwable $e) {}
        }

        return [
            'success' => true,
            'warning' => true,
            'message' => "PPPoE Secret tersimpan di database lokal.",
        ];
    }

    /**
     * Get complete live system info, hardware resources, and PPP profiles from MikroTik (Supports v7 API, v6 Legacy API, & Telnet)
     */
    public function getSystemInfo(): array
    {
        $port = (int) ($this->port ?: 8728);
        $isTelnetPort = ($port === 23);

        // 1. If Port 23 or Telnet requested, run Telnet service directly
        if ($isTelnetPort) {
            $telnetService = new \App\Services\RouterTelnetService();
            $telnetInfo = $telnetService->getSystemInfo($this->ip_address, $port, $this->username ?: 'admin', $this->password ?? '');
            if ($telnetInfo['connected']) {
                $this->update([
                    'status' => 'online',
                    'last_connected_at' => now(),
                    'model' => $telnetInfo['board_name'] ?? $this->model,
                    'ros_version' => $telnetInfo['version'] ?? $this->ros_version,
                ]);
                return $telnetInfo;
            }
            return $telnetInfo;
        }

        // 2. Try RouterOS API Client: First Modern v7 API, then Legacy v6 API (MD5 auth scheme)
        foreach ([false, true] as $isLegacy) {
            try {
                $client = $this->getClient($isLegacy);
                if ($client) {
                    // Identity
                    $identity = $this->name;
                    try {
                        $identityQuery = new \RouterOS\Query('/system/identity/print');
                        $identityRes = $client->query($identityQuery)->read();
                        if (!empty($identityRes[0]['name'])) {
                            $identity = $identityRes[0]['name'];
                        }
                    } catch (\Throwable $e) {}

                    // Resource
                    $res = [];
                    try {
                        $resourceQuery = new \RouterOS\Query('/system/resource/print');
                        $resourceRes = $client->query($resourceQuery)->read();
                        $res = $resourceRes[0] ?? [];
                    } catch (\Throwable $e) {}

                    // Routerboard info
                    $rb = [];
                    try {
                        $rbQuery = new \RouterOS\Query('/system/routerboard/print');
                        $rbRes = $client->query($rbQuery)->read();
                        $rb = $rbRes[0] ?? [];
                    } catch (\Throwable $e) {}

                    // PPP Profiles
                    $profiles = [];
                    try {
                        $profileQuery = new \RouterOS\Query('/ppp/profile/print');
                        $profileRes = $client->query($profileQuery)->read();
                        if (is_array($profileRes)) {
                            $profiles = $profileRes;
                        }
                    } catch (\Throwable $e) {}

                    // Active PPP Sessions
                    $actives = [];
                    try {
                        $activeQuery = new \RouterOS\Query('/ppp/active/print');
                        $activeRes = $client->query($activeQuery)->read();
                        if (is_array($activeRes)) {
                            $actives = $activeRes;
                        }
                    } catch (\Throwable $e) {}

                    $detectedModel = $res['board-name'] ?? ($rb['model'] ?? $this->model);
                    $detectedVersion = $res['version'] ?? $this->ros_version;

                    $this->update([
                        'status' => 'online',
                        'last_connected_at' => now(),
                        'model' => $detectedModel ?: $this->model,
                        'ros_version' => $detectedVersion ?: $this->ros_version,
                    ]);

                    $protocolName = $isLegacy ? 'RouterOS v6 API (Legacy)' : 'RouterOS v7 API';

                    return [
                        'connected' => true,
                        'protocol' => $protocolName,
                        'identity' => $identity,
                        'board_name' => $detectedModel ?: 'Mikrotik RouterOS',
                        'version' => $detectedVersion ?: '-',
                        'uptime' => $res['uptime'] ?? '-',
                        'cpu_load' => isset($res['cpu-load']) ? $res['cpu-load'] . '%' : '0%',
                        'cpu_count' => $res['cpu-count'] ?? 1,
                        'cpu' => $res['cpu'] ?? '-',
                        'cpu_frequency' => isset($res['cpu-frequency']) ? $res['cpu-frequency'] . ' MHz' : '-',
                        'memory_total' => !empty($res['total-memory']) ? round($res['total-memory'] / 1024 / 1024, 1) . ' MB' : '-',
                        'memory_free' => !empty($res['free-memory']) ? round($res['free-memory'] / 1024 / 1024, 1) . ' MB' : '-',
                        'hdd_total' => !empty($res['total-hdd-space']) ? round($res['total-hdd-space'] / 1024 / 1024, 1) . ' MB' : '-',
                        'hdd_free' => !empty($res['free-hdd-space']) ? round($res['free-hdd-space'] / 1024 / 1024, 1) . ' MB' : '-',
                        'serial_number' => $rb['serial-number'] ?? '-',
                        'firmware' => $rb['current-firmware'] ?? ($rb['upgrade-firmware'] ?? '-'),
                        'profiles' => $profiles,
                        'active_count' => count($actives),
                    ];
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::info("API attempt (legacy=" . ($isLegacy ? '1' : '0') . ") failed on {$this->name}: " . $e->getMessage());
            }
        }

        // 3. Fallback: Automatic Telnet attempt if API failed
        try {
            $telnetService = new \App\Services\RouterTelnetService();
            $telnetInfo = $telnetService->getSystemInfo($this->ip_address, 23, $this->username ?: 'admin', $this->password ?? '');
            if ($telnetInfo['connected']) {
                $this->update([
                    'status' => 'online',
                    'last_connected_at' => now(),
                    'model' => $telnetInfo['board_name'] ?? $this->model,
                    'ros_version' => $telnetInfo['version'] ?? $this->ros_version,
                ]);
                return $telnetInfo;
            }
        } catch (\Throwable $e) {}

        return [
            'connected' => false,
            'error' => "Gagal terhubung ke {$this->ip_address} via API v6/v7 (port {$port}) maupun Telnet (port 23). Pastikan IP, Username, dan Password sudah benar serta service API (8728) atau Telnet (23) aktif di MikroTik.",
        ];
    }
}

