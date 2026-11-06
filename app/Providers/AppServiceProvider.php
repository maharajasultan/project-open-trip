<?php
// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ── Gunakan Bootstrap 5 untuk pagination ────────────
        Paginator::useBootstrapFive();

        // ── Strict mode di local: deteksi N+1 & mass assign ─
        Model::shouldBeStrict(app()->isLocal());
    }
}