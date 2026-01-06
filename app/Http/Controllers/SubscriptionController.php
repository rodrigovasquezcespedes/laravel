<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function cancel(Request $request, $id)
    {
        $user = $request->user();
        $subscription = Subscription::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();
        $subscription->status = 'cancelled';
        $subscription->expires_at = now();
        $subscription->save();
        // Enviar email de cancelación
        if ($user->email) {
            \Mail::to($user->email)->send(new \App\Mail\SubscriptionCancelled($subscription));
        }
        return response()->json(['success' => true, 'subscription' => $subscription]);
    }
}
