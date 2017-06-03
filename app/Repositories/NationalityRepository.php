<?php


namespace App\Repositories;

use App\Models\Nationality;
use Illuminate\Support\Facades\DB;

class NationalityRepository
{
    protected $nationality;

    public function __construct(Nationality $nationality)
    {
        $this->nationality = $nationality;
    }

    /**
     * @return mixed
     */
    public function getNationalities(){
        return DB::table('nationalities')
            ->orderBy('name', 'asc')
            ->get();
    }
}