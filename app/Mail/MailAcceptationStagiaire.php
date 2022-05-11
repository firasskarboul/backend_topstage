<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Stagiaire;

class MailAcceptationStagiaire extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    //public $stagiaire;// $details;
    public function __construct($data) //  $details 
    {
         $this->data = $data;
      // $this->$details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
      // return $this->from('nourkhazri2@gmail.com')->view('Mails.acceptation');
       return $this->from('nourkhazri2@gmail.com')->subject(' Acceptation Demande de Stage')->view('emails.acceptationMail')->with('data' ,  $this->data);
    }
}
