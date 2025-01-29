<?php

namespace App\Providers;

use App\Interfaces\BuscaCnpjServiceInterface;
use App\Interfaces\FornecedorRepositoryInterface;
use App\Interfaces\FornecedorServiceInterface;
use App\Repositories\FornecedorRepository;
use App\Services\BuscaCnpjService;
use App\Services\FornecedorService;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FornecedorRepositoryInterface::class, FornecedorRepository::class);
        $this->app->bind(FornecedorServiceInterface::class, FornecedorService::class);

        $this->app->bind(BuscaCnpjServiceInterface::class, BuscaCnpjService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Passport::loadKeysFrom(__DIR__ . '/../secrets/oauth');
    }
}
