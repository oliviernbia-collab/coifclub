<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminContactReply extends Mailable
{
    use Queueable, SerializesModels;

    public ContactMessage $contact;
    public string $reply;

    public function __construct(ContactMessage $contact, string $reply)
    {
        $this->contact = $contact;
        $this->reply = $reply;
    }

    public function build()
    {
        return $this->subject('Réponse à votre message : ' . $this->contact->subject)
                    ->view('emails.admin_contact_reply');
    }
}
