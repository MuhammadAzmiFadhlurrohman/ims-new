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
     * Test connection to the Router (Socket ping/port check)
     */
    public function testConnection(): array
    {
        $host = $this->ip_address;
        $port = $this->port ?: 8728;
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

            return [
                'success' => true,
                'message' => "Koneksi berhasil! Router merespons di port {$port} dalam {$duration} ms.",
                'latency' => $duration,
            ];
        }

        $this->update([
            'status' => 'offline',
        ]);

        return [
            'success' => false,
            'message' => "Gagal terhubung ke {$host}:{$port}. ({$errstr} [{$errno}])",
            'latency' => null,
        ];
    }

    /**
     * Get RouterOS API Client instance
     */
    public function getClient(): ?\RouterOS\Client
    {
        try {
            return new \RouterOS\Client([
                'host' => $this->ip_address,
                'user' => $this->username ?: 'admin',
                'pass' => $this->password ?? '',
                'port' => (int) ($this->port ?: 8728),
                'ssl'  => (bool) ($this->use_ssl ?? false),
                'timeout' => 3,
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning("RouterOS connection error [{$this->name}]: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get PPP Profiles from Router
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

        try {
            $client = $this->getClient();
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
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::info("Could not fetch PPP profiles live from router {$this->name}: " . $e->getMessage());
        }

        return $defaultProfiles;
    }

    /**
     * Create PPPoE Secret on MikroTik Router
     */
    public function createPppSecret(
        string $username,
        string $password,
        ?string $profile = null,
        ?string $localAddress = null,
        ?string $remoteAddress = null,
        ?string $comment = null
    ): array {
        try {
            $client = $this->getClient();
            if ($client) {
                // Check if secret already exists
                $checkQuery = (new \RouterOS\Query('/ppp/secret/print'))
                    ->where('name', $username);
                $existing = $client->query($checkQuery)->read();

                if (!empty($existing) && is_array($existing) && count($existing) > 0) {
                    // Update existing secret
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

                // Add new secret
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
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning("MikroTik API create secret error: " . $e->getMessage());
            return [
                'success' => true,
                'warning' => true,
                'message' => "PPPoE Secret tersimpan di database lokal. (MikroTik offline: {$e->getMessage()})",
            ];
        }

        return [
            'success' => true,
            'warning' => true,
            'message' => "PPPoE Secret tersimpan di database lokal. (Router sedang offline)",
        ];
    }
}
