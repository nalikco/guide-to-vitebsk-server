<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Telegram\InitDataCheckerServiceContract;
use App\Contracts\Telegram\TokenProviderContract;
use App\Contracts\Uploads\ImageServiceContract;
use App\Contracts\Users\AuthenticateServiceContract;
use App\Services\Telegram\InitDataCheckerService;
use App\Services\Telegram\TokenService;
use App\Services\Uploads\ImageService;
use App\Services\Users\AuthenticateService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[\Override]
    public function register(): void
    {
        $this->app->singleton(ImageServiceContract::class, ImageService::class);

        $this->app->singleton(InitDataCheckerServiceContract::class, InitDataCheckerService::class);
        $this->app->singleton(TokenProviderContract::class, TokenService::class);

        $this->app->singleton(AuthenticateServiceContract::class, AuthenticateService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
