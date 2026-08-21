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
     * Get complete live system info, hardware resources, and PPP profiles from MikroTik (Supports API & Telnet)
     */
    public function getSystemInfo(): array
    {
        $port = (int) ($this->port ?: 8728);
        $isTelnetPort = ($port === 23);

        // 1. If Port 23 or Telnet requested, run Telnet service first
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

        // 2. Try RouterOS API Client
        try {
            $client = $this->getClient();
            if ($client) {
                // 1. Identity
                $identity = $this->name;
                try {
                    $identityQuery = new \RouterOS\Query('/system/identity/print');
                    $identityRes = $client->query($identityQuery)->read();
                    if (!empty($identityRes[0]['name'])) {
                        $identity = $identityRes[0]['name'];
                    }
                } catch (\Throwable $e) {}

                // 2. Resource
                $res = [];
                try {
                    $resourceQuery = new \RouterOS\Query('/system/resource/print');
                    $resourceRes = $client->query($resourceQuery)->read();
                    $res = $resourceRes[0] ?? [];
                } catch (\Throwable $e) {}

                // 3. Routerboard info
                $rb = [];
                try {
                    $rbQuery = new \RouterOS\Query('/system/routerboard/print');
                    $rbRes = $client->query($rbQuery)->read();
                    $rb = $rbRes[0] ?? [];
                } catch (\Throwable $e) {}

                // 4. PPP Profiles
                $profiles = [];
                try {
                    $profileQuery = new \RouterOS\Query('/ppp/profile/print');
                    $profileRes = $client->query($profileQuery)->read();
                    if (is_array($profileRes)) {
                        $profiles = $profileRes;
                    }
                } catch (\Throwable $e) {}

                // 5. Active PPP Sessions
                $actives = [];
                try {
                    $activeQuery = new \RouterOS\Query('/ppp/active/print');
                    $activeRes = $client->query($activeQuery)->read();
                    if (is_array($activeRes)) {
                        $actives = $activeRes;
                    }
                } catch (\Throwable $e) {}

                // Auto-update model & ros_version if available
                $detectedModel = $res['board-name'] ?? ($rb['model'] ?? $this->model);
                $detectedVersion = $res['version'] ?? $this->ros_version;

                $this->update([
                    'status' => 'online',
                    'last_connected_at' => now(),
                    'model' => $detectedModel ?: $this->model,
                    'ros_version' => $detectedVersion ?: $this->ros_version,
                ]);

                return [
                    'connected' => true,
                    'protocol' => 'RouterOS API',
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
            \Illuminate\Support\Facades\Log::info("API connection failed on {$this->name}, attempting Telnet fallback: " . $e->getMessage());
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
            'error' => "Gagal terhubung ke {$this->ip_address} via API (port {$port}) maupun Telnet (port 23). Pastikan IP, Username, dan Password sudah benar serta service API / Telnet aktif di MikroTik.",
        ];
    }
}

