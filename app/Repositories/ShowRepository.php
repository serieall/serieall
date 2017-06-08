<?php


namespace App\Repositories;

use App\Jobs\AddShowManually;
use App\Jobs\AddShowFromTVDB;
use App\Jobs\UpdateShowManually;
use App\Jobs\DeleteShow;

use App\Models\Show;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Class ShowRepository
 * @package App\Repositories\Admin
 */
class ShowRepository
{
    /**
     * @var Show
     */
    protected $show;
    protected $seasonRepository;

    /**
     * ShowRepository constructor.
     *
     * @param Show $show
     * @param \App\Repositories\SeasonRepository $seasonRepository
     */
    public function __construct(Show $show, SeasonRepository $seasonRepository)
    {
        $this->show = $show;
        $this->seasonRepository = $seasonRepository;
    }

    /**
     * ADMIN
     */

    /**
     * On vérifie si la série n'a pas déjà été récupérée.
     * Si c'est le cas, on renvoie une erreur.
     * Sinon, on lance le job d'ajout via TheTVDB et on renvoi un status OK.
     *
     * @param $inputs
     * @return bool
     */
    public function createShowJob($inputs){
        $checkIDTheTVDB = $this->show->where('thetvdb_id', $inputs['thetvdb_id'])->first();

        if(is_null($checkIDTheTVDB)){
            dispatch(new AddShowFromTVDB($inputs));
            return $dispatchOK = true;
        }
        else
        {
            return $dispatchOK = false;
        }
    }

    /**
     * On vérifie si la série n'a pas déjà été ajoutée.
     * Si c'est le cas, on renvoie une erreur.
     * Sinon, on lance le job de création manuelle et on renvoi un status OK.
     *
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
     * On crée un job de mise à jour manuel et on renvoi OK.
     *
     * @param $inputs
     * @return bool
     */
    public function updateManuallyShowJob($inputs){
        dispatch(new UpdateShowManually($inputs));

        return true;
    }

    /**
     * On crée un job de suppression d'une série et on renvoi OK.
     *
     * @param $id
     * @param $userID
     * @return bool
     * @internal param $inputs
     */
    public function deleteJob($id, $userID){
        dispatch(new DeleteShow($id, $userID));

        return true;
    }

    /**
     * SITE
     */

    /**
     * Récupération des informations de la fiche:
     * Série, saisons, épisodes, genres, nationalités, chaines, note, résumé
     *
     * @param $show_url
     * @return array
     */

    public function getInfoShowFiche($show_url)
    {
        // En fonction de la route, on récupère les informations sur la série différemment
        if (Route::current()->getName() == "show.fiche") {
            $show = $this->getShowByURL($show_url);
        } elseif (Route::current()->getName() == "show.details") {
            $show = $this->getShowDetailsByURL($show_url);
        }
        else {
            $show = $this->getShowByURL($show_url);
        }

        // On récupère les saisons, genres, nationalités et chaines
        $seasons = $this->seasonRepository->getSeasonsCountEpisodesForShowByID($show->id);
        $genres = formatRequestInVariable($show->genres);
        $nationalities = formatRequestInVariable($show->nationalities);
        $channels = formatRequestInVariable($show->channels);

        // On récupère la note de la série, et on calcule la position sur le cercle
        $noteCircle = noteToCircle($show->moyenne);

        // Détection du résumé à afficher (fr ou en)
        if(empty($show->synopsis_fr)) {
            $synopsis = $show->synopsis;
        }
        else {
            $synopsis = $show->synopsis_fr;
        }

        // Faut-il couper le résumé ? */
        $numberCharaMaxResume = config('param.nombreCaracResume');
        if(strlen($synopsis) <= $numberCharaMaxResume) {
            $showSynopsis = $synopsis;
            $fullSynopsis = false;
        }
        else {
            $showSynopsis = cutResume($synopsis);
            $fullSynopsis = true;
        }

        return compact('show', 'seasons', 'genres', 'nationalities', 'channels', 'noteCircle', 'synopsis', 'showSynopsis', 'fullSynopsis');
    }

    /**
     * GET FONCTIONS
     */

    /**
     * Récupère la liste des séries avec le compte des saisons et des épisodes, la ou les nationalités, et la ou les chaînes.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     *
     */
    public function getAllShowsWithCountSeasonsAndEpisodes(){
        return $this->show->with('nationalities', 'channels')
            ->withCount('episodes')
            ->withCount('seasons')
            ->get();
    }

    /**
     * Récupère la série avec son paramètre URL. On ajoute les saisons, les épisodes, les genres, les nationalités et les chaînes.
     *
     * @param $show_url
     * @return mixed
     */
    public function getShowByURL($show_url){
        return $this->show->where('show_url', $show_url)
            ->with('seasons', 'episodes', 'genres', 'nationalities', 'channels')
            ->first();
    }

    /**
     * On récupère les détails de la série avec son paramètre URL.
     * La différence avec la requête du dessus est surtout le fait que l'on récupère tout le casting.
     *
     * @param $show_url
     * @return mixed
     */
    public function getShowDetailsByURL($show_url){
        return $this->show->where('shows.show_url', '=', $show_url)->with(['channels', 'nationalities', 'creators', 'genres', 'actors' => function($q)
        {
            $q->select('artists.id', 'artists.name', 'artists.artist_url', 'artistables.role')
                ->orderBy('artists.name', 'asc');
        }])->first();
    }

    /**
     * On récupère une série grâce à son ID.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getByID($id){
        return $this->show->findOrFail($id);
    }

    /**
     * On récupère les détails de la série avec son ID.
     * @param $id
     * @return Show|\Illuminate\Database\Eloquent\Builder
     */
    public function getAllInformationsOnShowByID($id){
        return $this->show->where('shows.id', '=', $id)->with(['channels', 'nationalities', 'creators', 'genres', 'seasons', 'actors' => function($q)
        {
            $q->select('artists.id', 'artists.name', 'artistables.role');
        }])->first();
    }
}