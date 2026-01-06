<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    // Simulación de integración de pago
    public function pay(Request $request)
    {
        $user = $request->user();
        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);
        $amount = $product->price;

        // Aquí iría la integración real con Stripe/Paypal
        // Simulación de pago exitoso
        $transactionId = 'TX-' . uniqid();

        // Crear orden
        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'amount' => $amount,
            'transaction_id' => $transactionId,
            'status' => 'paid',
        ]);

        // Crear suscripción
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'order_id' => $order->id,
            'status' => 'active',
            'started_at' => now(),
            'expires_at' => now()->addMonth(),
        ]);

        // Enviar email de confirmación
        \Mail::to($user->email)->send(new \App\Mail\SubscriptionCreated($subscription));

        return response()->json([
            'success' => true,
            'order' => $order,
            'subscription' => $subscription,
        ]);
    }
}
