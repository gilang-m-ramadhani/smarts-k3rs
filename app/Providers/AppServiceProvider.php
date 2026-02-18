<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        $this->configureRateLimiting();
    }

    /**
     * Configure rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // ── Login: 5 percobaan per menit per IP ──────────────────
        // Mencegah brute-force attack pada halaman login.
        RateLimiter::for('login', function (Request $request) {
            $key = $request->input('email', '') . '|' . $request->ip();

            return Limit::perMinute(5)
                ->by($key)
                ->response(function (Request $request, array $headers) {
                    $retryAfter = $headers['Retry-After'] ?? 60;

                    return back()->withErrors([
                        'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$retryAfter} detik.",
                    ])->onlyInput('email');
                });
        });

        // ── Global Web: 60 request per menit per user ────────────
        // Rate limit umum untuk semua halaman authenticated.
        RateLimiter::for('web', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(60)->by($request->user()->id)
                : Limit::perMinute(30)->by($request->ip());
        });

        // ── Livewire: 120 request per menit per user ─────────────
        // Livewire mengirim banyak AJAX request, jadi limit lebih tinggi.
        RateLimiter::for('livewire', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(120)->by($request->user()->id)
                : Limit::perMinute(60)->by($request->ip());
        });

        // ── Export: 10 request per menit ──────────────────────────
        // Mencegah abuse pada fitur export PDF/Excel yang resource-heavy.
        RateLimiter::for('export', function (Request $request) {
            return Limit::perMinute(10)->by(
                $request->user()?->id ?: $request->ip()
            );
        });
    }
}
