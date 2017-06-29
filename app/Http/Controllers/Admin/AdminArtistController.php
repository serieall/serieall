<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\ArtistUpdateRequest;
use Illuminate\Support\Facades\Log;
use App\Repositories\ArtistRepository;
use App\Repositories\ShowRepository;

class AdminArtistController extends Controller
{

    protected $artistRepository;
    protected $showRepository;

    /**
     * AdminArtistController constructor.
     *
     * @param ArtistRepository $artistRepository
     * @param ShowRepository $showRepository
     */
    public function __construct(ArtistRepository $artistRepository, ShowRepository $showRepository)
    {
        $this->artistRepository = $artistRepository;
        $this->showRepository = $showRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\Response
     * @internal param ShowCreateRequest|Request $request
     */
    public function store()
    {

    }

    /**
     * Affiche la liste des acteurs d'une série en fonction de son ID
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $show = $this->showRepository->getByID($id);
        $actors = $this->artistRepository->getActorsByShowID($show);


        return view('admin.artists.show', compact('actors', 'show'));
    }

    public function update(ArtistUpdateRequest $request)
    {
        Log::info($request);
    }

    /**
     * Editer la série
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}