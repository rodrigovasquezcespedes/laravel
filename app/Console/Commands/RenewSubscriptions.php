<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use Carbon\Carbon;

class RenewSubscriptions extends Command
{
    protected $signature = 'subscriptions:renew';
    protected $description = 'Renueva suscripciones activas que han expirado y crea una nueva si corresponde.';

    public function handle()
    {
        $now = Carbon::now();
        $renewed = 0;
        $expired = 0;

        $subscriptions = Subscription::where('status', 'active')
            ->where('expires_at', '<=', $now)
            ->get();

        foreach ($subscriptions as $subscription) {
            // Aquí podrías intentar cobrar de nuevo, etc.
            // Por ahora, simplemente renovamos automáticamente
            $subscription->started_at = $now;
            $subscription->expires_at = $now->copy()->addMonth();
            $subscription->save();
            // Enviar email de renovación
            if ($subscription->user && $subscription->user->email) {
                \Mail::to($subscription->user->email)->send(new \App\Mail\SubscriptionRenewed($subscription));
            }
            $renewed++;
        }

        $this->info("Suscripciones renovadas: $renewed");
        return 0;
    }
}
