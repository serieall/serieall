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
            ->withCount('episodes')
            ->withCount('seasons')
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
     * @param $id
     */
    public function destroy($id){
        // On cherche la série
        $show = $this->getByID($id);

        // On détache tous les artistes, chaines, nationalités et les genres
        $show->artists()->detach();
        $show->channels()->detach();
        $show->nationalities()->detach();
        $show->genres()->detach();

        // On récupère les saisons
        $seasons = $show->seasons()->get();

        // Pour chaque saison
        foreach($seasons as $season){
            // On récupère les épisodes
            $episodes = $season->episodes()->get();

            // Pour chaque épisode
            foreach($episodes as $episode){
                // On détache les artistes
                $episode->artists()->detach();

                // On le supprime
                $episode->delete();
            }
            // On supprime la saison
            $season->delete();
        }

        // On supprime la série
        $show->delete();
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

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getByID($id){
        return $this->show->findOrFail($id);
    }

    /**
     * @param $id
     * @return Show|\Illuminate\Database\Eloquent\Builder
     */
    public function getAllInformationsOnShowByID($id){
        return $this->show->where('shows.id', '=', $id)->with(['channels', 'nationalities', 'creators', 'genres', 'actors' => function($q)
        {
            $q->select('artists.id', 'artists.name', 'artistables.role');
        }])->first();
    }

    /**
     * @param $objets
     * @return string
     */
    public function formatRequestInVariable($objets){
        $liste = '';
        // Pour chaque chaine on incrémente dans une variable
        foreach ($objets as $objet){
            $liste.= $objet->name . ',';
        }

        // On enlève la dernière virgule
        $liste = substr($liste, 0, -1);

        return $liste;
    }
}