<?php

namespace App\Mail;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotePaymentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $quote;
    public $paymentAmount;
    public $isAdvancePayment;

    public function __construct(Quote $quote, $paymentAmount, $isAdvancePayment)
    {
        $this->quote = $quote;
        $this->paymentAmount = $paymentAmount;
        $this->isAdvancePayment = $isAdvancePayment;
    }

    public function build()
    {
        return $this->subject('Nueva Cotización Pagada - El Roble')
                    ->view('pages.emails.quote-payment-notification');
    }
}