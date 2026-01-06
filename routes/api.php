<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

// Tenant routes
Route::middleware(['api', \App\Http\Middleware\TenantMiddleware::class])->group(function () {
    // These routes require X-Tenant-ID header and Valid Token
    // For MVP, we might require Auth for all tenant operations or public for Storefront

    // Storefront Public Routes (Products, etc)
    Route::get('/products', function () {
        return \App\Models\Product::all();
    });

    // Dashboard Protected Routes
    Route::group(['middleware' => 'auth:api'], function () {
        // Orders, Settings, etc.
        // Endpoint de pago y suscripción
        Route::post('/pay', [\App\Http\Controllers\PaymentController::class, 'pay']);
        // Cancelar suscripción
        Route::post('/subscriptions/{id}/cancel', [\App\Http\Controllers\SubscriptionController::class, 'cancel']);
        // Listar suscripciones del usuario
        Route::get('/subscriptions', function (Request $request) {
            return \App\Models\Subscription::where('user_id', $request->user()->id)->get();
        });
        // Historial de pagos (órdenes)
        Route::get('/orders', function (Request $request) {
            return \App\Models\Order::where('user_id', $request->user()->id)->get();
        });

        // Saber si el usuario es admin
        Route::get('/me/is-admin', function (Request $request) {
            return ['is_admin' => $request->user()->hasRole('admin')];
        });
    });
});
