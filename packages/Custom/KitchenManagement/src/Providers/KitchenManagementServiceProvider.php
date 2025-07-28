<?php

namespace Custom\KitchenManagement\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Event;
use Webkul\Sales\Models\Order;
use Custom\KitchenManagement\Listeners\OrderStatusListener;

class KitchenManagementServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register your package services
        $this->mergeConfigFrom(
            __DIR__.'/../Config/kitchen-management.php', 'kitchen-management'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
        
        // Load views
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'kitchen-management');
        
        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        
        // Load translations
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'kitchen-management');
        
        // Publish assets
        $this->publishes([
            __DIR__.'/../Config/kitchen-management.php' => config_path('kitchen-management.php'),
            __DIR__.'/../Resources/views' => resource_path('views/vendor/kitchen-management'),
            __DIR__.'/../Resources/lang' => lang_path('vendor/kitchen-management'),
        ], 'kitchen-management');

        // Register event listeners
        $this->registerEventListeners();
    }

    /**
     * Register event listeners.
     */
    protected function registerEventListeners(): void
    {
        // Listen for order status changes
        Event::listen('order.status.changed', OrderStatusListener::class);
    }
} 