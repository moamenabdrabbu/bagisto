<?php

namespace Custom\PaymentGateway\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class PaymentGatewayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register your package services
        $this->mergeConfigFrom(
            __DIR__.'/../Config/payment-gateway.php', 'payment-gateway'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        
        // Load views
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'payment-gateway');
        
        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        
        // Load translations
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'payment-gateway');
        
        // Publish assets
        $this->publishes([
            __DIR__.'/../Config/payment-gateway.php' => config_path('payment-gateway.php'),
            __DIR__.'/../Resources/views' => resource_path('views/vendor/payment-gateway'),
            __DIR__.'/../Resources/lang' => lang_path('vendor/payment-gateway'),
        ], 'payment-gateway');
    }
} 