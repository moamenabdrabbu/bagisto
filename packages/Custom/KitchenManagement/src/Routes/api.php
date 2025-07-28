<?php

use Illuminate\Support\Facades\Route;
use Custom\KitchenManagement\Http\Controllers\WorkingHoursController;
use Custom\KitchenManagement\Http\Controllers\KitchenOrderController;

/*
|--------------------------------------------------------------------------
| Kitchen Management API Routes
|--------------------------------------------------------------------------
|
| Here you can define the API routes for your kitchen management package.
|
*/

Route::group(['prefix' => 'api/kitchen-management', 'middleware' => ['api']], function () {
    // Working Hours API
    Route::get('/working-hours', [WorkingHoursController::class, 'getWorkingHours']);
    Route::get('/kitchen-status', [WorkingHoursController::class, 'getKitchenStatus']);

    // Orders API
    Route::get('/orders/status/{status}', [KitchenOrderController::class, 'getOrdersByStatus']);
    Route::get('/orders/{orderId}', [KitchenOrderController::class, 'getOrderDetails']);
    Route::put('/orders/{orderId}/status', [KitchenOrderController::class, 'updateStatus']);
}); 