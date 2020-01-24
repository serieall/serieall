<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Notifications\ContactRequest as ContactRequestNotification;
use App\Models\Contact;
use App\Notifications\ContactNotification;
use App\Repositories\ContactRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;

/**
 * Class ContactController
 * @package App\Http\Controllers
 */
class ContactController extends Controller
{
    protected $contactRepository;

    /**
     * ContactController constructor.
     * @param ContactRepository $contactRepository
     */
    public function __construct(ContactRepository $contactRepository) {
      $this->contactRepository = $contactRepository;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'objet' => 'required|min:10',
//            'captcha' => 'required|captcha',
            'message' => 'required']);
    }

    /**
     * Send a Contact Request
     *
     * @param ContactRequest $contactRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendContact(ContactRequest $contactRequest) {
        $this->validator($contactRequest->all())->validate();

        // Send notification
        Notification::route('mail', $contactRequest->email)
            ->notify(new ContactNotification());

        Notification::route('mail', config('mail.username'))
            ->notify(new ContactRequestNotification($contactRequest->name, $contactRequest->email, $contactRequest->objet, $contactRequest->message));
    }
}