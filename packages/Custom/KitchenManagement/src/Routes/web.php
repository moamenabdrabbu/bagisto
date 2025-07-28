<?php

use Illuminate\Support\Facades\Route;
use Custom\KitchenManagement\Http\Controllers\WorkingHoursController;
use Custom\KitchenManagement\Http\Controllers\KitchenOrderController;

/*
|--------------------------------------------------------------------------
| Kitchen Management Web Routes
|--------------------------------------------------------------------------
|
| Here you can define the web routes for your kitchen management package.
|
*/

Route::group(['prefix' => 'kitchen-management', 'middleware' => ['web', 'admin']], function () {
    // Working Hours Management
    Route::get('/working-hours', [WorkingHoursController::class, 'index'])
        ->name('kitchen-management.working-hours.index');
    
    Route::post('/working-hours', [WorkingHoursController::class, 'update'])
        ->name('kitchen-management.working-hours.update');

    // Kitchen Dashboard
    Route::get('/dashboard', [KitchenOrderController::class, 'dashboard'])
        ->name('kitchen-management.dashboard');

    // Order Status Management
    Route::put('/orders/{orderId}/status', [KitchenOrderController::class, 'updateStatus'])
        ->name('kitchen-management.orders.update-status');
}); 