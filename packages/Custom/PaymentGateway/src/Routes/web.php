<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Payment Gateway Routes
|--------------------------------------------------------------------------
|
| Here you can define the routes for your payment gateway package.
|
*/

Route::group(['prefix' => 'payment-gateway', 'namespace' => 'Custom\PaymentGateway\Http\Controllers'], function () {
    Route::get('/', 'PaymentController@index')->name('payment-gateway.index');
    Route::post('/process', 'PaymentController@process')->name('payment-gateway.process');
    Route::get('/callback', 'PaymentController@callback')->name('payment-gateway.callback');
}); 