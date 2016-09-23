<?php

namespace App\Http\Controllers;

use App\Jobs\AddShowFromTVDB;
use Illuminate\Http\Request;
use App\Repositories\AdminShowRepository;

use App\Http\Requests;
use Auth;
use App\Models\Show;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

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

        return view('admin/shows/addShow', compact('navActive'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Array $inputs)
    {
        $client = new Client(['base_uri' => 'https://api.thetvdb.com/']);

        $getToken = $client->request('POST', '/login', [
            'json' => [
                'apikey' => '64931690DCC5FC6B',
                'username' => 'Youkoulayley',
                'userkey' => '6EE6A1F4BF0DDA46',
            ]
        ])->getBody();

        $getToken = json_decode($getToken);

        $token = $getToken->token;

        $getShow = $client->request('GET', '/series/'. $inputs['thetvdb_id'], [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        ])->getBody();

        $getShow = json_decode($getShow);

        foreach ($getShow->data as $show){
            $show->thetvdbid = $theTVDBID;
            $show->name = $show->seriesName;

            $show_new = new $this->show;
            $this->save($show_new, $show);
            return $show_new;
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
