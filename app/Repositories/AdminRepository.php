<?php


namespace App\Repositories;

use App\Models\Show;

class AdminRepository
{
    protected $show;

    public function __construct(Show $show)
    {
        $this->show = $show;
    }

    public function getShowByName($n){
        return $this->show->with('channels', 'nationalities')
            ->withCount('seasons')
            ->orderBy('shows.name')
            ->paginate($n);
    }
}