<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionRenewed extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;

    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    public function build()
    {
        return $this->subject('¡Tu suscripción ha sido renovada!')
            ->view('emails.subscription_renewed');
    }
}
