<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\ShowUpdateManuallyRequest;
use App\Repositories\LogRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\ShowCreateRequest;
use App\Http\Requests\ShowCreateManuallyRequest;

use App\Repositories\ShowRepository;
use App\Repositories\ArtistRepository;
use App\Repositories\ChannelRepository;
use App\Repositories\GenreRepository;
use App\Repositories\NationalityRepository;
use App\Repositories\SeasonRepository;

/**
 * Class AdminShowController
 * @package App\Http\Controllers\Admin
 */
class AdminShowController extends Controller
{

    protected $showRepository;
    protected $artistRepository;
    protected $channelRepository;
    protected $genreRepository;
    protected $nationalityRepository;
    protected $seasonRepository;
    protected $logRepository;

    /**
     * AdminShowController constructor.
     * @param ShowRepository $showRepository
     * @param ArtistRepository $artistRepository
     * @param ChannelRepository $channelRepository
     * @param GenreRepository $genreRepository
     * @param NationalityRepository $nationalityRepository
     * @param SeasonRepository $seasonRepository
     * @param LogRepository $logRepository
     */
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
     * Return the nidex of the show administration
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // On récupère la liste des séries
        $shows = $this->showRepository->getAllShowsWithCountSeasonsAndEpisodes();

        // On retourne la vue
        return view('admin/shows/index', compact('shows'));
    }

    /**
     * Affiche le formulaire de création via theTVDB
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        // On retourne la vue
        return view('admin/shows/create/thetvdb');
    }

    /**
     * Affiche le formulaire de création manuelle
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createManually()
    {
        // On retourne la vue
        return view('admin/shows/create/manually');
    }

    /**
     * Met à jour une série manuellement
     *
     * @param ShowUpdateManuallyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateManually(ShowUpdateManuallyRequest $request): RedirectResponse
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);
        $dispatchOK = $this->showRepository->updateManuallyShowJob($inputs);

        if($dispatchOK) {
            $state_header = 'status_header';
            $state = 'status';

            $message_header= 'Série en cours de modification';
            $message = 'La demande de modification de la série a été effectuée. Le serveur la traitera dès que possible.';
        }
        else {
            $state_header = 'wanring_header';
            $state = 'warning';

            $message_header= 'Erreur';
            $message = 'Problème lors de la mise à jour de la série !';
        }

        return redirect()->back()
            ->with($state_header, $message_header)
            ->with($state, $message);
    }

    /**
     * Mettre à jour les informations sur la série
     *
     * @param $id
     * @return RedirectResponse
     */
    public function edit($id)
    {
        $show = $this->showRepository->getInfoShowByID($id);
        $genres = formatRequestInVariable($show->genres);
        $nationalities = formatRequestInVariableNoSpace($show->nationalities);
        $channels = formatRequestInVariableNoSpace($show->channels);
        $creators = formatRequestInVariableNoSpace($show->creators);

        // On retourne la vue
        return view('admin/shows/edit', compact('show', 'genres', 'nationalities', 'channels', 'creators'));
    }


    /**
     * Enregistre une nouvelle série via theTVDB
     *
     * @param ShowCreateRequest|Request $request
     * @return RedirectResponse
     */
    public function store(ShowCreateRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        $dispatchOK = $this->showRepository->createShowJob($inputs);

        if($dispatchOK) {
            $state_header = 'status_header';
            $state = 'status';

            $message_header= 'Série en cours d\'ajout';
            $message = 'La demande de création de série a été effectuée. Le serveur la traitera dès que possible.';
        }
        else {
            $state_header = 'wanring_header';
            $state = 'warning';

            $message_header= 'Série déjà ajoutée';
            $message = 'La série que vous voulez créer existe déjà chez Série-All.';
        }

        return redirect()->back()
            ->with($state_header, $message_header)
            ->with($state, $message);
    }

    /**
     * Enregistre une nouvelle série créée manuellement
     *
     * @param ShowCreateManuallyRequest|Request $request
     * @return RedirectResponse
     */

    public function storeManually(ShowCreateManuallyRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        $this->showRepository->createManuallyShowJob($inputs);

        return response()->json();
    }

    /**
     * Redirection JSON
     *
     * @return RedirectResponse
     */
    public function redirectJSON()
    {
        return redirect()->route('admin.shows.index')
            ->with('status_header', 'Série en cours d\'ajout')
            ->with('status', 'La demande de cManuallyréation de série a été effectuée. Le serveur la traitera dès que possible.');
    }

    /**
     * Supprime une série ainsi que tous les éléments qui lui sont rattachés
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $userID = Auth::user()->id;

        $dispatchOK = $this->showRepository->deleteJob($id, $userID);

        if($dispatchOK) {
            $state_header = 'status_header';
            $state = 'status';

            $message_header= 'Suppression';
            $message = 'La série est en cours de suppression.';
        }
        else {
            $state_header = 'warning_header';
            $state = 'warning';

            $message_header= 'Erreur';
            $message = 'Problème lors de la suppression de la série !';
        }

        return redirect()->back()
            ->with($state_header, $message_header)
            ->with($state, $message);

    }
}
