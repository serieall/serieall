<?php


namespace App\Repositories\Admin;

use App\Jobs\AddShowManually;
use App\Models\Show;
use App\Jobs\AddShowFromTVDB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class AdminShowRepository
 * @package App\Repositories\Admin
 */
class AdminShowRepository
{
    /**
     * @var Show
     */
    protected $show;

    /**
     * AdminShowRepository constructor.
     * @param Show $show
     */
    public function __construct(Show $show)
    {
        $this->show = $show;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getShowByName(){
        return $this->show->with('nationalities', 'channels')
            ->withCount('seasons', 'episodes')
            ->get();
    }

    /**
     * @param $inputs
     * @return bool
     */
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

    /**
     * @param $inputs
     * @return bool
     */
    public function createManuallyShowJob($inputs){
        $URLShow = Str::slug($inputs['name']);
        $verifURLShow = $this->show->where('show_url', $URLShow)->first();

        if(is_null($verifURLShow)){
            dispatch(new AddShowManually($inputs));
            return $createOK = true;
        }
        else
        {
            return $createOK = false;
        }
    }

    /**
     * @return mixed
     */
    public function getActors(){
        return DB::table('artists')
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * @return mixed
     */
    public function getGenres(){
        return DB::table('genres')
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * @return mixed
     */
    public function getChannels(){
        return DB::table('channels')
            ->orderBy('name', 'asc')
            ->get();
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