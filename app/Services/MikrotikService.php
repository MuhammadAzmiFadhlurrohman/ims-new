<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use RouterOS\Client;
use RouterOS\Query;

class MikrotikService
{
    protected ?Client $client = null;

    public function __construct()
    {
        try {
            $host = config('mikrotik.host');
            $user = config('mikrotik.user');
            $pass = config('mikrotik.pass');
            $port = (int) config('mikrotik.port', 8728);
            $timeout = (int) config('mikrotik.timeout', 10);

            if ($host && $user) {
                $this->client = new Client([
                    'host' => $host,
                    'user' => $user,
                    'pass' => $pass,
                    'port' => $port,
                    'timeout' => $timeout,
                ]);
            }
        } catch (Exception $e) {
            Log::error('Mikrotik Connection Error: ' . $e->getMessage());
        }
    }

    public function isConnected(): bool
    {
        return $this->client !== null;
    }

    public function createPppoeUser(string $username, string $password, string $profile = 'default'): bool
    {
        if (!$this->client) {
            Log::warning("Mikrotik client not connected when creating user {$username}");
            return false;
        }

        try {
            $query = (new Query('/ppp/secret/add'))
                ->equal('name', $username)
                ->equal('password', $password)
                ->equal('service', 'pppoe')
                ->equal('profile', $profile);

            $this->client->query($query)->read();
            return true;
        } catch (Exception $e) {
            Log::error("Mikrotik createPppoeUser error: {$e->getMessage()}");
            return false;
        }
    }

    public function isolateUser(string $pppoeUsername, string $isolirProfile = 'PROFILE-ISOLIR'): bool
    {
        if (!$this->client) {
            Log::warning("Mikrotik client not connected when isolating user {$pppoeUsername}");
            return false;
        }

        try {
            // Find secret ID
            $findQuery = (new Query('/ppp/secret/print'))
                ->where('name', $pppoeUsername);
            $secrets = $this->client->query($findQuery)->read();

            if (!empty($secrets)) {
                $id = $secrets[0]['.id'];
                $updateQuery = (new Query('/ppp/secret/set'))
                    ->equal('.id', $id)
                    ->equal('profile', $isolirProfile);
                $this->client->query($updateQuery)->read();
            }

            $this->kickUser($pppoeUsername);
            return true;
        } catch (Exception $e) {
            Log::error("Mikrotik isolateUser error: {$e->getMessage()}");
            return false;
        }
    }

    public function restoreUser(string $pppoeUsername, string $originalProfile = 'default'): bool
    {
        if (!$this->client) {
            Log::warning("Mikrotik client not connected when restoring user {$pppoeUsername}");
            return false;
        }

        try {
            $findQuery = (new Query('/ppp/secret/print'))
                ->where('name', $pppoeUsername);
            $secrets = $this->client->query($findQuery)->read();

            if (!empty($secrets)) {
                $id = $secrets[0]['.id'];
                $updateQuery = (new Query('/ppp/secret/set'))
                    ->equal('.id', $id)
                    ->equal('profile', $originalProfile);
                $this->client->query($updateQuery)->read();
            }

            $this->kickUser($pppoeUsername);
            return true;
        } catch (Exception $e) {
            Log::error("Mikrotik restoreUser error: {$e->getMessage()}");
            return false;
        }
    }

    public function kickUser(string $pppoeUsername): bool
    {
        if (!$this->client) {
            return false;
        }

        try {
            $findActive = (new Query('/ppp/active/print'))
                ->where('name', $pppoeUsername);
            $activeSessions = $this->client->query($findActive)->read();

            foreach ($activeSessions as $session) {
                if (isset($session['.id'])) {
                    $kickQuery = (new Query('/ppp/active/remove'))
                        ->equal('.id', $session['.id']);
                    $this->client->query($kickQuery)->read();
                }
            }
            return true;
        } catch (Exception $e) {
            Log::error("Mikrotik kickUser error: {$e->getMessage()}");
            return false;
        }
    }
}
