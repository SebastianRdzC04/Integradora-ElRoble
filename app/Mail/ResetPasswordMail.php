<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $email;

    /**
     * Create a new message instance.
     *
     * @param  string  $url
     * @return void
     */
    public function __construct($url,$email)
    {
        $this->url = $url;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        session(['email' => $this->email]);
        return $this->view('pages.emails.reset_password') 
                    ->subject('Restablecer tu contraseña')
                    ->with([
                        'url' => $this->url,
                        'email' => $this->email 
                    ]);

        
    }
}