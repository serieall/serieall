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
            #dispatch(new AddShowFromTVDB($inputs));
            dispatch(new UpdateShowFromTvDB());
            return $dispatchOK = true;
        }
        else
        {
            return $dispatchOK = false;
        }
    }

    public function getArtists(){
        return Artist::all();
    }

    public function getGenres(){
        return Genre::all();
    }

    public function getChannels(){
        return Channel::all();
    }

    public function getNationalities(){
        return Nationality::all();
    }


}