<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        return $this->from('info@flowershoplk.com', 'FlowerShoplk')
            ->subject('FlowerShoplk Contact Inquiry')
            ->view('mails.contact-email',['contact_name'=>$request->name,'contact_email'=>$request->email,'content'=>$request->message])
            ->to('shafnawitel@gmail.com')
            ->cc(['shafna@witellsolutions.com']);
        //return $this->view('view.name');
    }
}
