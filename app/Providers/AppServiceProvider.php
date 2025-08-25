<?php

namespace App\Providers;

// Use System
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        // Enforce morph map
        Relation::enforceMorphMap([
            'user' => \App\Models\User::class,
            // 'mahasiswa'  => \App\Models\Mahasiswa::class,
            // 'dosen'  => \App\Models\Dosen::class,
        ]);
    }
}
