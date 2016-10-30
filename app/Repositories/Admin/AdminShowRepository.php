<?php


namespace App\Repositories\Admin;

use App\Models\Channel;
use App\Models\Nationality;
use App\Models\Show;
use App\Models\Artist;
use App\Models\Genre;
use App\Jobs\AddShowFromTVDB;
use Illuminate\Support\Facades\DB;
use App\Jobs\UpdateShowFromTVDB;

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

    public function createShowJob($inputs){
        $verifIDTheTVDB = $this->show->where('thetvdb_id', $inputs['thetvdb_id'])->first();
        if(is_null($verifIDTheTVDB)){
            dispatch(new AddShowFromTVDB($inputs));
            return $dispatchOK = true;
        }
        else
        {
            return $dispatchOK = false;
        }
    }

    public function getActors(){
        return DB::table('artists')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getGenres(){
        return DB::table('genres')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getChannels(){
        return DB::table('channels')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getNationalities(){
        return DB::table('nationalities')
            ->orderBy('name', 'asc')
            ->get();
    }


}