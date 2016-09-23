<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use GuzzleHttp\Client;

class AddShowFromTVDB extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $show_tvdbid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($show_tvdbid)
    {
        $this->show_tvdbid = $show_tvdbid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*
        |--------------------------------------------------------------------------
        | Définition des variables
        |--------------------------------------------------------------------------
        */
        $theTVDBID = $this->show_tvdbid;
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

        /*
        |--------------------------------------------------------------------------
        | Recupération de la série
        |--------------------------------------------------------------------------
        | Le paramètre passé est l'ID de TheTVDB passé dans le formulaire
        | On précise la version de l'API a utiliser, que l'on veut recevoir du JSON.
        | On passe également en paramètre le token.
        */
        $getShow = $client->request('GET', '/series/'. $theTVDBID, [
            'headers' => [
                'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                'Authorization' => 'Bearer ' . $token,
            ]
        ])->getBody();

        /*
        |--------------------------------------------------------------------------
        | Décodage du JSON
        |--------------------------------------------------------------------------
        */
        $show = json_decode($getShow);

        /*
        |--------------------------------------------------------------------------
        | Création de la série
        |--------------------------------------------------------------------------
        | On commence par créer l'objet qui contiendra toutes les informations de
        | la série à créer, basé sur le Model 'Show'.
        | On définit les valeurs des différents champs voulus
        | On crée l'objet en base.
        */
        $show_new = new $this->show;

        $show_new->thetvdb_id = $theTVDBID;
        $show_new->name = $show->data->seriesName;
        $show_new->show_url = $show->data->seriesName;

        $show_new->save();
    }
}
