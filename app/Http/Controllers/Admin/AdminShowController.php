<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Repositories\LogRepository;
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
use Illuminate\Support\Facades\Log;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shows = $this->showRepository->getShowByName();

        return view('admin/shows/indexShows', compact('shows', 'navActive'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $artists = $this->artistRepository->getArtists();
        $genres = $this->genreRepository->getGenres();
        $channels = $this->channelRepository->getChannels();
        $nationalities = $this->nationalityRepository->getNationalities();

        return view('admin/shows/addShow', compact('navActive', 'artists', 'genres', 'channels', 'nationalities'));
    }

    /**
     * Show the form for creating a new resource manually.
     *
     * @return \Illuminate\Http\Response
     */
    public function createManually()
    {
        $artists = $this->artistRepository->getArtists();
        $genres = $this->genreRepository->getGenres();
        $channels = $this->channelRepository->getChannels();
        $nationalities = $this->nationalityRepository->getNationalities();

        return view('admin/shows/createManually', compact('navActive', 'artists', 'genres', 'channels', 'nationalities'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param ShowCreateRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShowCreateRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        $dispatchOK = $this->showRepository->createShowJob($inputs);

        if($dispatchOK) {
            return redirect(route('adminShow.index'))
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
     * Store a newly manually created resource in storage.
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
     * Store a newly manually created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectJSON()
    {
        return redirect()->route('adminShow.index')
            ->with('status_header', 'Série en cours d\'ajout')
            ->with('status', 'La demande de création de série a été effectuée. Le serveur la traitera dès que possible.');
    }

    /**
     * Show the form for editing the specified resource.
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

        $allActors = $this->artistRepository->getArtists();
        $allGenres = $this->genreRepository->getGenres();
        $allChannels = $this->channelRepository->getChannels();
        $allNationalities = $this->nationalityRepository->getNationalities();

        return view('admin/shows/edit',  compact('show', 'allActors', 'allGenres', 'allChannels', 'allNationalities', 'navActive', 'genres', 'channels', 'nationalities', 'creators', 'seasonsEpisodes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ShowUpdateManuallyRequest|Request $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function updateManually(ShowUpdateManuallyRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        $this->showRepository->updateManuallyShowJob($inputs);

        Log::info('test');
        return response()->json();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->showRepository->destroy($id);

        return redirect()->back();
    }
}
