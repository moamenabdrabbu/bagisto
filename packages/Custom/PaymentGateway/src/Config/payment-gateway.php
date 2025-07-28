<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Payment Gateway Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the custom payment gateway.
    |
    */

    'name' => env('PAYMENT_GATEWAY_NAME', 'Custom Gateway'),
    
    'enabled' => env('PAYMENT_GATEWAY_ENABLED', false),
    
    'api_key' => env('PAYMENT_GATEWAY_API_KEY'),
    
    'api_secret' => env('PAYMENT_GATEWAY_API_SECRET'),
    
    'sandbox' => env('PAYMENT_GATEWAY_SANDBOX', true),
    
    'webhook_url' => env('PAYMENT_GATEWAY_WEBHOOK_URL'),
]; 