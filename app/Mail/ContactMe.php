<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMe extends Mailable 
{
    use Queueable, SerializesModels;

    public $details; 

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details= null)
    {
        $this->details =$details; 
    }
    
    

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Defining Subjecct in the Build method');
      //  $this->later(10); des not work, needs second paraemeter for queue
        return $this->view('emails.contact-me');
    }
}
