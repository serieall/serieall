<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\Artist;

use Carbon\Carbon;
use App\Jobs\AddShowFromTVDB;
use Illuminate\Http\Request;
use App\Http\Requests\ShowCreateRequest;

use App\Repositories\Admin\AdminShowRepository;

class AdminShowController extends Controller
{

    protected $adminShowRepository;

    public function __construct(AdminShowRepository $adminShowRepository)
    {
        $this->adminShowRepository = $adminShowRepository;
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

        $artists = $this->adminShowRepository->getArtists();
        $genres = $this->adminShowRepository->getGenres();
        $channels = $this->adminShowRepository->getChannels();
        $nationalities = $this->adminShowRepository->getNationalities();

        return view('admin/shows/addShow', compact('navActive', 'artists', 'genres', 'channels', 'nationalities'));
    }

    /**
     * Show the form for creating a new resource manually.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_manually()
    {
        #Variable qui détecte dans quelle partie de l'admin on se trouve
        $navActive = 'show';

        $artists = $this->adminShowRepository->getArtists();
        $genres = $this->adminShowRepository->getGenres();
        $channels = $this->adminShowRepository->getChannels();
        $nationalities = $this->adminShowRepository->getNationalities();

        return view('admin/shows/addShowManually', compact('navActive', 'artists', 'genres', 'channels', 'nationalities'));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
