<?php


namespace App\Repositories;

use App\Models\Contact;

/**
 * Class ContactRepository
 * @package App\Repositories\Admin
 */
class ContactRepository
{
    protected $contact;

    /**
     * LogRepository constructor.
     *
     * @param Contact $contact
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * On récupère tous les contacts
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllContacts(){
        return $this->contact
            ->with('user')
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * On récupère un contact grâce à son ID
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getContactByID($id){
        return $this->contact->findOrFail($id);
    }
}
