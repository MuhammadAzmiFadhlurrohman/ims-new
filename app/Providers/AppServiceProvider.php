<?php

namespace App\Providers;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ── 1. RATE LIMITING (BRUTE FORCE PROTECTION) ──
        RateLimiter::for('login', function (Request $request) {
            $key = ($request->input('email') ?: 'unknown') . '|' . $request->ip();
            return Limit::perMinute(5)->by($key)->response(function () {
                return response()->json([
                    'message' => 'Terlalu banyak percobaan login yang gagal. Silakan coba lagi dalam 1 menit.',
                ], 429);
            });
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // ── 2. LOGGING AKTIVITAS MENCURIGAKAN (AGREGASI GAGAL LOGIN JADI 1 BARIS) ──
        Event::listen(Failed::class, function (Failed $event) {
            $email = $event->credentials['email'] ?? 'unknown';
            $ip = request()->ip();
            $userAgent = request()->userAgent();

            // Cari log gagal login dari IP & Email yang sama dalam 15 menit terakhir
            $recentLog = Activity::where('log_name', 'suspicious_activity')
                ->where('event', 'failed_login')
                ->where('created_at', '>=', now()->subMinutes(15))
                ->latest()
                ->get()
                ->first(function ($log) use ($ip, $email) {
                    $props = $log->properties;
                    return isset($props['ip_address'], $props['email'])
                        && $props['ip_address'] === $ip
                        && $props['email'] === $email;
                });

            if ($recentLog) {
                $props = $recentLog->properties ? $recentLog->properties->toArray() : [];
                $count = (int) ($props['attempt_count'] ?? 1) + 1;
                $props['attempt_count'] = $count;
                $props['last_attempt_at'] = now()->toDateTimeString();

                $recentLog->update([
                    'description' => "Ada {$count}x percobaan login gagal untuk email: {$email} dari IP: {$ip}",
                    'properties' => $props,
                    'created_at' => now(), // update waktu ke percobaan terbaru
                ]);
            } else {
                activity('suspicious_activity')
                    ->event('failed_login')
                    ->withProperties([
                        'email' => $email,
                        'ip_address' => $ip,
                        'user_agent' => $userAgent,
                        'attempt_count' => 1,
                        'first_attempt_at' => now()->toDateTimeString(),
                        'last_attempt_at' => now()->toDateTimeString(),
                    ])
                    ->log("Ada 1x percobaan login gagal untuk email: {$email} dari IP: {$ip}");
            }
        });

        // ── 3. LOGGING AKTIVITAS LOGIN BERHASIL ──
        Event::listen(Login::class, function (Login $event) {
            $user = $event->user;
            $ip = request()->ip();

            activity('authentication')
                ->causedBy($user)
                ->event('successful_login')
                ->withProperties([
                    'ip_address' => $ip,
                    'user_agent' => request()->userAgent(),
                    'logged_in_at' => now()->toDateTimeString(),
                ])
                ->log("Pengguna {$user->name} ({$user->email}) berhasil login dari IP: {$ip}");
        });
    }
}
