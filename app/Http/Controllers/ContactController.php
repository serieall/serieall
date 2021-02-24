<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Notifications\ContactNotification;
use App\Repositories\ContactRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

/**
 * Class ContactController.
 */
class ContactController extends Controller
{
    protected $contactRepository;

    /**
     * ContactController constructor.
     */
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'objet' => 'required|min:10',
            'captcha' => 'required|captcha',
            'message' => 'required', ]);
    }

    /**
     * Send a Contact Request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendContact(ContactRequest $contactRequest)
    {
        $this->validator($contactRequest->all())->validate();

        Log::info('ContactSend : The captcha for '.$contactRequest->name.'/'.$contactRequest->email.' is : '.$contactRequest->captcha);

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

        Notification::route('mail', Config::get('defaults.email'))
            ->notify(new ContactNotification());

        // Redirection
        return redirect()->back()->with('success', 'Votre demande a bien été envoyée.');
    }
}
