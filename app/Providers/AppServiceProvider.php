<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Penempatan;
use App\Policies\PenempatanPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Policy mappings.
     */
    protected $policies = [
        Penempatan::class => PenempatanPolicy::class,
    ];

    /**
     * Register services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}