<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Notifications\ContactNotification;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    public function __construct() {
      //
    }

    public function sendContact(ContactRequest $contactRequest) {
        // Stockage de la demande dans la BDD
        $contact = new Contact();
        $contact->email = $contactRequest->email;
        $contact->objet = $contactRequest->objet;
        $contact->message = $contactRequest->message;
        $contact->save();

        // Envoi de la notification
        Notification::route('mail', $contactRequest->email)
            ->notify(new ContactNotification());

        // Redirection
        return redirect()->back()->with('success', 'Votre demande a bien été envoyée.');
    }
}