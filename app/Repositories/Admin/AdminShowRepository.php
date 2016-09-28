<?php


namespace App\Repositories\Admin;

use App\Models\Show;
use App\Models\Artist;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;

class AdminShowRepository
{
    protected $show;

    public function __construct(Show $show)
    {
        $this->show = $show;
    }

    public function getShowByName(){
        return $this->show->with('nationalities', 'channels')
            ->withCount('seasons', 'episodes')
            ->get();
    }

    public function getArtists(){
        return Artist::all();
    }

    public function getGenres(){
    return Genre::all();
}
}