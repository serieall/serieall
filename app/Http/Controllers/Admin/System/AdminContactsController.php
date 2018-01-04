<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Notifications\ReplyContactNotification;
use App\Repositories\ContactRepository;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ReplyContactRequest;
use Illuminate\Support\Facades\Notification;

class AdminContactsController extends Controller
{
    protected $nbPerPage = 20;
    protected $contactRepository;

    /**
     * AdminContactsController constructor.
     *
     * @param ContactRepository $contactRepository
     */
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Renvoi vers la page admin/system/contacts/index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $contacts = $this->contactRepository->getAllContacts();

        return view('admin/system/contacts/index', compact('contacts'));
    }

    /**
     * Affiche le contenu d'un contact
     * Renvoi vers la page admin/system/contacts/view
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id){
        $contact = $this->contactRepository->getContactByID($id);

        return view('admin/system/contacts/view', compact('contact'));
    }

    /**
     * Reply to a contact request
     *
     * @param ReplyContactRequest $replyContactRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function replyContact(ReplyContactRequest $replyContactRequest) {
        $contact = $this->contactRepository->getContactByID($replyContactRequest->id);

        $contact->admin_id = $replyContactRequest->admin_id;
        $contact->admin_message = $replyContactRequest->admin_message;
        $contact->save();

        // Envoi de la notification
        Notification::route('mail', $contact->email)
            ->notify(new ReplyContactNotification($contact->user['username'], $contact->admin_message));

        return redirect()->back();
    }
}
