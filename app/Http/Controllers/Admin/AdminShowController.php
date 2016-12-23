<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Repositories\LogRepository;
use Illuminate\Http\Request;
use App\Http\Requests\ShowCreateRequest;
use App\Http\Requests\ShowCreateManuallyRequest;
use App\Http\Requests\ShowUpdateManuallyRequest;

use App\Repositories\Admin\AdminShowRepository;
use App\Repositories\SeasonRepository;
use Illuminate\Support\Facades\Log;

class AdminShowController extends Controller
{

    protected $adminShowRepository;
    protected $seasonRepository;
    protected $logRepository;

    public function __construct(AdminShowRepository $adminShowRepository, SeasonRepository $seasonRepository, LogRepository $logRepository)
    {
        $this->adminShowRepository = $adminShowRepository;
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
        #Variable qui détecte dans quelle partie de l'admin on se trouve
        $navActive = 'show';
        $shows = $this->adminShowRepository->getShowByName();

        return view('admin/shows/indexShows', compact('shows', 'navActive'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        #Variable qui détecte dans quelle partie de l'admin on se trouve
        $navActive = 'show';

        $actors = $this->adminShowRepository->getActors();
        $genres = $this->adminShowRepository->getGenres();
        $channels = $this->adminShowRepository->getChannels();
        $nationalities = $this->adminShowRepository->getNationalities();

        return view('admin/shows/addShow', compact('navActive', 'actors', 'genres', 'channels', 'nationalities'));
    }

    /**
     * Show the form for creating a new resource manually.
     *
     * @return \Illuminate\Http\Response
     */
    public function createManually()
    {
        #Variable qui détecte dans quelle partie de l'admin on se trouve
        $navActive = 'show';

        $actors = $this->adminShowRepository->getActors();
        $genres = $this->adminShowRepository->getGenres();
        $channels = $this->adminShowRepository->getChannels();
        $nationalities = $this->adminShowRepository->getNationalities();

        return view('admin/shows/createManually', compact('navActive', 'actors', 'genres', 'channels', 'nationalities'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShowCreateRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        $dispatchOK = $this->adminShowRepository->createShowJob($inputs);

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeManually(ShowCreateManuallyRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        $createOK = $this->adminShowRepository->createManuallyShowJob($inputs);

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
        #Variable qui détecte dans quelle partie de l'admin on se trouve
        $navActive = 'show';



        $show = $this->adminShowRepository->getAllInformationsOnShowByID($id);

        $genres = $this->adminShowRepository->formatRequestInVariable($show->genres);
        $channels = $this->adminShowRepository->formatRequestInVariable($show->channels);
        $nationalities = $this->adminShowRepository->formatRequestInVariable($show->nationalities);
        $creators = $this->adminShowRepository->formatRequestInVariable($show->creators);

        $seasonsEpisodes = $this->seasonRepository->getSeasonsEpisodesForShowByID($id);

        $allActors = $this->adminShowRepository->getActors();
        $allGenres = $this->adminShowRepository->getGenres();
        $allChannels = $this->adminShowRepository->getChannels();
        $allNationalities = $this->adminShowRepository->getNationalities();

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

        $this->adminShowRepository->updateManuallyShowJob($inputs);

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
        $this->adminShowRepository->destroy($id);

        return redirect()->back();
    }
}
