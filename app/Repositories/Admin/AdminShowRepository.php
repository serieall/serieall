<?php


namespace App\Repositories\Admin;

use App\Models\Show;
use App\Models\Artist;
use Illuminate\Support\Facades\DB;

class AdminShowRepository
{
    protected $show;
    protected $artist;

    public function __construct(Show $show, Artist $artist)
    {
        $this->show = $show;
        $this->artist = $artist;
    }

    public function getShowByName(){
        return $this->show->with('nationalities', 'channels')
            ->withCount('seasons', 'episodes')
            ->get();
    }

    public function getArtists(){
        return Artist::all();
    }
}