<?php

namespace App\Http\Controllers;

use App\Jobs\AddShowFromTVDB;
use Illuminate\Http\Request;
use App\Repositories\AdminShowRepository;

use App\Http\Requests\ShowCreateRequest;
use Auth;
use App\Models\Show;
use GuzzleHttp\Client;

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


        $api_key = config('thetvdb.apikey');
        $api_username = config('thetvdb.username');
        $api_userkey = config('thetvdb.userkey');
        $api_url = config('thetvdb.url');
        $api_version = config('thetvdb.version');
        /*
        |--------------------------------------------------------------------------
        | Création du client
        |--------------------------------------------------------------------------
        */
        $client = new Client(['base_uri' => $api_url]);

        /*
        |--------------------------------------------------------------------------
        | Requête d'authentification
        |--------------------------------------------------------------------------
        | L'objectif est de récupérer un token d'identification.
        | On passe en paramètre :
        |   - l'API Key,
        |   - le compte utilisateur,
        |   - La clé utilisateur.
        | Et on précise la version de l'API a utiliser.
        */
        $getToken = $client->request('POST', '/login', [
            'header' => [
                'Accept' => 'application/vnd.thetvdb.v' . $api_version,
            ],
            'json' => [
                'apikey' => $api_key,
                'username' => $api_username,
                'userkey' => $api_userkey,
            ]
        ])->getBody();

        /*
        |--------------------------------------------------------------------------
        | Décodage du JSON et récupération du token dans une variable
        |--------------------------------------------------------------------------
        */
        $getToken = json_decode($getToken);

        $token = $getToken->token;


        $getShow = $client->request('GET', '/series/'. $theTVDBID, [
            'headers' => [
                'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                'Authorization' => 'Bearer ' . $token,
                'Accept-Language' => 'fr',
            ]
        ])->getBody();

        /*
        |--------------------------------------------------------------------------
        | Décodage du JSON
        |--------------------------------------------------------------------------
        */
        $getShow = json_decode($getShow);
        if (isset($getShow->errors->invalidLanguage)){
            $error_language = 'no';
        }
        else{
            $error_language = 'yes';
        }

        dd($error_language);











        dispatch(new AddShowFromTVDB($theTVDBID));

        #Variable qui détecte dans quelle partie de l'admin on se trouve
        $navActive = 'show';
        $shows = $this->adminShowRepository->getShowByName();
        return view('admin/shows/indexShows', compact('shows', 'navActive'));
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
