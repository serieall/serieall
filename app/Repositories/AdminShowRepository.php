<?php


namespace App\Repositories;

use App\Models\Show;
use Illuminate\Support\Facades\DB;

class AdminShowRepository
{
    protected $show;

    public function __construct(Show $show)
    {
        $this->show = $show;
    }

    public function getShowByName($n){
        return $this->show->with('nationalities', 'channels')
            ->withCount('seasons', 'episodes')
            ->orderBy('shows.name')
            ->paginate($n);
    }
}