<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use App\Notifications\RenewalReminder;
use Carbon\Carbon;

class SendRenewalReminders extends Command
{
    protected $signature = 'subscriptions:send-renewal-reminders';
    protected $description = 'Envía recordatorios de renovación a usuarios con suscripciones próximas a vencer.';

    public function handle()
    {
        $soon = Carbon::now()->addDays(3);
        $subs = Subscription::where('status', 'active')
            ->where('expires_at', '<=', $soon)
            ->where('expires_at', '>', Carbon::now())
            ->get();
        foreach ($subs as $sub) {
            if ($sub->user) {
                $sub->user->notify(new RenewalReminder());
            }
        }
        $this->info('Recordatorios enviados: ' . $subs->count());
    }
}
