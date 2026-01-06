<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;

    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    public function build()
    {
        return $this->subject('¡Suscripción creada exitosamente!')
            ->view('emails.subscription_created');
    }
}
