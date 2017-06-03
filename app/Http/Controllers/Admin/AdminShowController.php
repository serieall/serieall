<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Repositories\LogRepository;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\ShowCreateRequest;
use App\Http\Requests\ShowCreateManuallyRequest;
use App\Http\Requests\ShowUpdateManuallyRequest;

use App\Repositories\ShowRepository;
use App\Repositories\ArtistRepository;
use App\Repositories\ChannelRepository;
use App\Repositories\GenreRepository;
use App\Repositories\NationalityRepository;
use App\Repositories\SeasonRepository;

class AdminShowController extends Controller
{

    protected $showRepository;
    protected $artistRepository;
    protected $channelRepository;
    protected $genreRepository;
    protected $nationalityRepository;
    protected $seasonRepository;
    protected $logRepository;

    public function __construct(ShowRepository $showRepository,
                                ArtistRepository $artistRepository,
                                ChannelRepository $channelRepository,
                                GenreRepository $genreRepository,
                                NationalityRepository $nationalityRepository,
                                SeasonRepository $seasonRepository,
                                LogRepository $logRepository)
    {
        $this->showRepository = $showRepository;
        $this->artistRepository = $artistRepository;
        $this->channelRepository = $channelRepository;
        $this->genreRepository = $genreRepository;
        $this->nationalityRepository = $nationalityRepository;
        $this->seasonRepository = $seasonRepository;
        $this->logRepository = $logRepository;
    }

    /**
     * Affiche l'index de l'administation des séries
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // On récupère la liste des séries
        $shows = $this->showRepository->getShowByName();

        // On retourne la vue
        return view('admin/shows/index', compact('shows'));
    }

    /**
     * Affiche le formulaire de création via theTVDB
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // On retourne la vue
        return view('admin/shows/create');
    }

    /**
     * Affiche le formulaire de création manuelle
     *
     * @return \Illuminate\Http\Response
     */
    public function createManually()
    {
        // On retourne la vue
        return view('admin/shows/createManually');
    }


    /**
     * Enregistre une nouvelle série via theTVDB
     *
     * @param ShowCreateRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShowCreateRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        $dispatchOK = $this->showRepository->createShowJob($inputs);

        if($dispatchOK) {
            return redirect(route('admin.shows.index'))
                ->with('status_header', 'Série en cours d\'ajout')
                ->with('status', 'La demande de création de série a été effectuée. Le serveur la traitera dès que possible.');
        }
        else {
            return redirect()->back()
                ->with('warning_header', 'Série déjà ajoutée')
                ->with('warning', 'La série que vous voulez créer existe déjà chez Série-All.');
        }
    }

    /**
     * Enregistre une nouvelle série créée manuellement
     *
     * @param ShowCreateManuallyRequest|Request $request
     * @return \Illuminate\Http\Response
     */

    public function storeManually(ShowCreateManuallyRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        $createOK = $this->showRepository->createManuallyShowJob($inputs);

        if($createOK) {
            return response()->json();
        }
    }

    /**
     * Redirection JSON
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectJSON()
    {
        return redirect()->route('admin.shows.index')
            ->with('status_header', 'Série en cours d\'ajout')
            ->with('status', 'La demande de création de série a été effectuée. Le serveur la traitera dès que possible.');
    }

    /**
     * Affiche le formulaire d'édition d'une série
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $show = $this->showRepository->getAllInformationsOnShowByID($id);

        $genres = $this->showRepository->formatRequestInVariable($show->genres);
        $channels = $this->showRepository->formatRequestInVariable($show->channels);
        $nationalities = $this->showRepository->formatRequestInVariable($show->nationalities);
        $creators = $this->showRepository->formatRequestInVariable($show->creators);

        $seasonsEpisodes = $this->seasonRepository->getSeasonsEpisodesForShowByID($id);

        return view('admin/shows/edit',  compact('show', 'allActors', 'allGenres', 'allChannels', 'allNationalities', 'navActive', 'genres', 'channels', 'nationalities', 'creators', 'seasonsEpisodes'));
    }

    /**
     * Met à jour une série
     *
     * @param ShowUpdateManuallyRequest|Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function updateManually(ShowUpdateManuallyRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        $this->showRepository->updateManuallyShowJob($inputs);

        return response()->json();
    }

    /**
     * Supprime une série ainsi que tous les éléments qui lui sont rattachés
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userID = Auth::user()->id;

        $dispatchOK = $this->showRepository->deleteJob($id, $userID);

        if($dispatchOK) {
            return redirect()->back()
                ->with('status_header', 'Suppression')
                ->with('status', 'La série est en cours de suppression.');
        }
        else {
            return redirect()->back()
                ->with('warning_header', 'Erreur')
                ->with('warning', 'Ca marche pô.');
        }
    }
}
