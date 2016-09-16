<?php


namespace App\Repositories;

use App\Models\Show;
use Illuminate\Support\Facades\DB;

class AdminRepository
{
    protected $show;

    public function __construct(Show $show)
    {
        $this->show = $show;
    }

    public function getShowByName($n){

        return $this->show->with('nationalities', 'channels', 'seasons', 'episodes')->paginate();
    }

}