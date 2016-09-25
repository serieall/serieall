<?php

namespace App\Http\Controllers;

use App\Jobs\AddShowFromTVDB;
use Illuminate\Http\Request;
use App\Repositories\AdminShowRepository;

use App\Http\Requests;
use App\Http\Requests\ShowCreateRequest;
use Auth;
use App\Models\Show;
use App\Http\Controllers\Components\ReplaceSpecialChars;


class AdminShowController extends Controller
{

    protected $adminShowRepository;
    protected $show;

    public function __construct(AdminShowRepository $adminShowRepository, Show $show)
    {
        $this->adminShowRepository = $adminShowRepository;
        $this->show = $show;
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

        $test = ReplaceSpecialChars::ReplaceSpecialChars('LOOOLL LLLLL');

        dd($test);

        return view('admin/shows/addShow', compact('navActive'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShowCreateRequest $request, Show $show)
    {
        $theTVDBID = $request->thetvdb_id;

        dispatch(new AddShowFromTVDB($theTVDBID));

        return route('adminShow.index');
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
