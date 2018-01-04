<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Notifications\ContactNotification;
use App\Repositories\ContactRepository;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository) {
      $this->contactRepository = $contactRepository;
    }

    /**
     * Send a Contact Request
     *
     * @param ContactRequest $contactRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendContact(ContactRequest $contactRequest) {
        // Stockage de la demande dans la BDD
        $contact = new Contact();
        $contact->name = $contactRequest->name;
        $contact->email = $contactRequest->email;
        $contact->objet = $contactRequest->objet;
        $contact->message = $contactRequest->message;
        $contact->save();

        // Envoi de la notification
        Notification::route('mail', $contact->email)
            ->notify(new ContactNotification());

        // Redirection
        return redirect()->back()->with('success', 'Votre demande a bien été envoyée.');
    }
}