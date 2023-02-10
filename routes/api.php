<?php

use App\Http\Controllers\Customer\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*Route::post('order/midtrans-callback', [OrderController::class, 'callback'])->name('order.callback');*/

Route::post('payment-notification-handler', [OrderController::class, 'payment_handler'])->name('payment.handler');
