<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleStripe(Request $request)
    {
        Log::info('Stripe webhook recibido', $request->all());
        // Aquí procesar eventos de Stripe
        return response()->json(['received' => true]);
    }
}
