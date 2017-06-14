<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

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
    public function __construct(ArtistRepository $artistRepository,
                                ShowRepository $showRepository)
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
     * Store a newly manually created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectJSON()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $idShow
     * @param $idActor
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function unlinkShow($idShow, $idActor)
    {
        $show = $this->showRepository->getByID($idShow);
        $suppression = $show->artists()->where('artists.id', '=', $idActor)->detach;
        dd($suppression);
    }
}
