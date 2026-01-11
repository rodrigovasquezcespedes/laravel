<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// API pública
Route::get('/public/docs', [\App\Http\Controllers\PublicApiController::class, 'docs']);
// Integración CRM/marketing
Route::post('/crm/subscribe', [\App\Http\Controllers\CRMController::class, 'subscribe']);
// Pruebas A/B
Route::post('/abtest/record', [\App\Http\Controllers\ABTestController::class, 'record']);
// Webhooks
Route::post('/webhooks/stripe', [\App\Http\Controllers\WebhookController::class, 'handleStripe']);
// Validar cupon
Route::post('/coupons/validate', [\App\Http\Controllers\CouponController::class, 'validateCoupon']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    // Recuperación de contraseña
    Route::post('forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('reset-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'reset']);
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
                                                // Soporte/tickets
                                                Route::get('/tickets', [\App\Http\Controllers\TicketController::class, 'index']);
                                                Route::post('/tickets', [\App\Http\Controllers\TicketController::class, 'store']);
                                            // Auditoría
                                            Route::get('/admin/audit-logs', [\App\Http\Controllers\AuditLogController::class, 'index']);
                                        // Suscripciones familiares
                                        Route::get('/families', [\App\Http\Controllers\FamilyController::class, 'index']);
                                        Route::post('/families', [\App\Http\Controllers\FamilyController::class, 'store']);
                                        Route::post('/families/{id}/add-user', [\App\Http\Controllers\FamilyController::class, 'addUser']);
                                    // Notificaciones
                                    Route::get('/me/notifications', [\App\Http\Controllers\NotificationController::class, 'index']);
                                    Route::post('/me/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead']);
                                // Panel de usuario
                                Route::get('/me/profile', [\App\Http\Controllers\UserProfileController::class, 'show']);
                                Route::put('/me/profile', [\App\Http\Controllers\UserProfileController::class, 'update']);
                            // Upgrade/Downgrade de plan
                            Route::post('/subscriptions/{id}/change-plan', [\App\Http\Controllers\PaymentController::class, 'changePlan']);
                        // Facturación PDF
                        Route::get('/orders/{id}/invoice', [\App\Http\Controllers\InvoiceController::class, 'download']);
                    // Carrito de compras
                    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index']);
                    Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add']);
                    Route::delete('/cart/item/{id}', [\App\Http\Controllers\CartController::class, 'remove']);
                    Route::delete('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear']);
                // Reportes para admin
                Route::get('/admin/reports', [\App\Http\Controllers\AdminReportController::class, 'index']);
            // Métodos de pago
            Route::get('/payment-methods', [\App\Http\Controllers\PaymentMethodController::class, 'index']);
            Route::post('/payment-methods', [\App\Http\Controllers\PaymentMethodController::class, 'store']);
            Route::put('/payment-methods/{id}', [\App\Http\Controllers\PaymentMethodController::class, 'update']);
            Route::delete('/payment-methods/{id}', [\App\Http\Controllers\PaymentMethodController::class, 'destroy']);
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
