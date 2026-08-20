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

        // ── 2. LOGGING AKTIVITAS MENCURIGAKAN (FAILED LOGIN / BRUTE FORCE) ──
        Event::listen(Failed::class, function (Failed $event) {
            $email = $event->credentials['email'] ?? 'unknown';
            $ip = request()->ip();
            $userAgent = request()->userAgent();

            activity('suspicious_activity')
                ->event('failed_login')
                ->withProperties([
                    'email' => $email,
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'attempted_at' => now()->toDateTimeString(),
                ])
                ->log("Percobaan login gagal untuk email: {$email} dari IP: {$ip}");
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
