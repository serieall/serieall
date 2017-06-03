<?php


namespace App\Repositories;

use App\Models\Nationality;
use Illuminate\Support\Facades\DB;

class NationalityRepository
{
    protected $nationality;

    /**
     * NationalityRepository constructor.
     *
     * @param Nationality $nationality
     */
    public function __construct(Nationality $nationality)
    {
        $this->nationality = $nationality;
    }

    /**
     * On récupère la liste des nationalités
     *
     * @return mixed
     */
    public function getNationalities(){
        return DB::table('nationalities')
            ->orderBy('name', 'asc')
            ->get();
    }
}