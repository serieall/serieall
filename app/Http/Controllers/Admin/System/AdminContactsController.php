<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Jobs\FlushLogs1Week;
use App\Repositories\ContactRepository;

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
}
