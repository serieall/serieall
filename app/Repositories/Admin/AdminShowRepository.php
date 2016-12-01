<?php


namespace App\Repositories\Admin;

use App\Models\Show;
use App\Jobs\AddShowFromTVDB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function createManuallyShowJob($inputs){
        $URLShow = Str::slug($inputs['name']);
        $verifURLShow = $this->show->where('show_url', $URLShow)->first();

        if(is_null($verifURLShow)){

            return $createOK = true;
        }
        else
        {
            return $createOK = false;
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