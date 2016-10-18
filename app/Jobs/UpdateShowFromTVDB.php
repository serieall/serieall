<?php

namespace App\Jobs;


use App\Models\Channel;
use App\Models\Nationality;
use App\Models\Show;
use App\Models\Genre;
use App\Models\Artist;
use App\Models\Temp;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use GuzzleHttp\Client;
use \Illuminate\Support\Str;

class UpdateShowFromTVDB extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $key_token = "token";
        $key_lastupdate = "last_update";
        $api_key = config('thetvdb.apikey');
        $api_username = config('thetvdb.username');
        $api_userkey = config('thetvdb.userkey');
        $api_url = config('thetvdb.url');
        $api_version = config('thetvdb.version');
        $hours_duration_token = config('thetvdb.hoursduration');

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
        | L'objectif est de récupérer un token d'identification si le dernier qu'on a récupéré a moins de 24h
        | On passe en paramètre :
        |   - l'API Key,
        |   - le compte utilisateur,
        |   - La clé utilisateur.
        | Et on précise la version de l'API a utiliser.
        */

        # Vérification de la présence de la clé token
        $keyToken = Temp::where('key', $key_token)->first();
        # Date actuelle en UTC
        $dateNow = Carbon::now();
        # Date de la dernière modification du token
        $dateKeyToken = $keyToken->updated_at;

        # Comparaison entre les deux dates
        $resetToken = $dateNow->diffInHours($dateKeyToken);

        # Si la dernière modification date de plus de 23h
        if ($resetToken > $hours_duration_token) {
            #On récupère un nouveau token et on l'enregistre en base
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
            $keyToken->value = $token;
            $keyToken->save();
        } else {
            # Sinon, on utilise celui en base
            $token = $keyToken->value;
        }

        /*
        |--------------------------------------------------------------------------
        | Récupération de la liste des mises à jour
        |--------------------------------------------------------------------------
        */
        # D'abord on récupère la date de dernière mise à jour
        $lastUpdate = Temp::where('key', $key_lastupdate)->first();
        $lastUpdate = $lastUpdate->value;

        # On fait chercher la liste des dernières modifications sur TheTVDB
        $getUpdate = $client->request('GET', 'updated/query?fromTime=' . $lastUpdate, [
            'headers' => [
                'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                'Authorization' => 'Bearer ' . $token,
            ]
        ])->getBody();

        $getUpdate = json_decode($getUpdate);

        $getUpdate = $getUpdate->data;

        foreach ($getUpdate as $update) {
            $idSerie = $update->id;

            # Vérification de la présence de la série dans notre BDD
            $serieInBDD = Show::where('thetvdb_id', $idSerie)->first();

            # Si la série existe
            if (!is_null($serieInBDD)) {
                Log::info('Modification de la série ' . $idSerie);

                /*
                |--------------------------------------------------------------------------
                | Recupération de la série en français et avec la langue par défaut
                |--------------------------------------------------------------------------
                | Le paramètre passé est l'ID de TheTVDB passé dans le formulaire
                | On précise la version de l'API a utiliser, que l'on veut recevoir du JSON.
                | On passe également en paramètre le token.
                */
                $getShow_fr = $client->request('GET', '/series/' . $idSerie, [
                    'headers' => [
                        'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                        'Authorization' => 'Bearer ' . $token,
                        'Accept-Language' => 'fr',
                    ]
                ])->getBody();

                $getShow_en = $client->request('GET', '/series/' . $idSerie, [
                    'headers' => [
                        'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                        'Authorization' => 'Bearer ' . $token,
                        'Accept-Language' => 'en',
                    ]
                ])->getBody();

                /*
                |--------------------------------------------------------------------------
                | Décodage du JSON et vérification que la langue française existe sur The TVDB
                | Si la langue fr n'est pas renseignée, on met la variable languageFR à 'no'
                |--------------------------------------------------------------------------
                */
                $getShow_fr = json_decode($getShow_fr);
                $getShow_en = json_decode($getShow_en);

                $show_en = $getShow_en->data;
                $show_fr = $getShow_fr->data;

                $resumeSerie = $serieInBDD->resume;
                # Si le résumé est à TBA dans notre base
                if ($resumeSerie == 'TBA') {
                    # On vérifie si le résumé est rempli en FR
                    if (!is_null($show_fr->overview)) {
                        # On sauvegarde le résumé en français
                        $serieInBDD->resume = $show_fr->overview;
                    } else {
                        # On vérifie que le résumé est rempli en EN
                        if (!is_null($show_en->overview)) {
                            # On sauvegarde le résumé en EN
                            $serieInBDD->resume = $show_en->overview;
                        }
                    }
                }

                $nomFRSerie = $serieInBDD->name_fr;
                # Si le nom FR est à TBA dans notre base
                if ($nomFRSerie == 'TBA') {
                    # On vérifie si le nom est rempli en FR
                    if (!is_null($show_fr->name)) {
                        # On sauvegarde le nom en français
                        $serieInBDD->name_fr = $show_fr->name;
                    }
                }

                $statutSerie = $serieInBDD->encours;
                # Si le statut est à 1 dans notre base
                if ($statutSerie == '1') {
                    # On vérifie le statut sur TheTVDB
                    if ($show_en->status == 'Ended') {
                        # On enregistre le nouveau statut
                        $serieInBDD->encours = 0;
                    }
                }

                $diffusionSerie = $serieInBDD->diffusion_us;
                # Si la diffusion est renseignée sur theTVDB
                if (!is_null($show_en->firstAired)) {
                    # Si la diffusion dans notre BDD est égale à celle dans TheTVDB
                    if ($diffusionSerie != $show_en->firstAired) {
                        # On enregistre la nouvelle diffusion
                        $serieInBDD->diffusion_us = $show_en->firstAired;
                        $dateTemp = date_create($show_en->firstAired);              # On transforme d'abord le texte récupéré par la requête en date
                        $serieInBDD->annee = date_format($dateTemp, "Y");           # Ensuite on récupère l'année
                    }
                }

                $serieInBDD->save();




                /*
                |--------------------------------------------------------------------------
                | Gestion des acteurs
                |--------------------------------------------------------------------------
                | On commence par récupérer les chaines du formulaire
                */
                $getActors = $client->request('GET', '/series/'. $idSerie . '/actors', [
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
                $actors = json_decode($getActors);
                $actors = $actors->data;

                if(!is_null($actors)) {
                    foreach ($actors as $actor) {
                        # Récupération du nom de l'acteur
                        $actorName = $actor->name;

                        # Récupération du rôle
                        $actorRole = $actor->role;
                        if (is_null($actorRole)) {
                            $actorRole = 'TBA';
                        }

                        # On supprime les espaces
                        $actor = trim($actorName);
                        # On met en forme l'URL
                        $actor_url = Str::slug($actor);
                        # Vérification de la présence de l'acteur
                        $actor_ref = Artist::where('artist_url', $actor_url)->first();

                        if(!is_null($actor_ref)) {
                            # On vérifie s'il est déjà lié à la série
                            $actor_liaison = Artist::has('shows', '==', $idSerie)->get();
                            if(is_null($actor_liaison)){
                                # On lie l'acteur à la série
                                $serieInBDD->artists()->attach($actor_ref->id, ['profession' => 'actor', 'role' => $actorRole]);
                            }
                        }
                        else{
                            # On prépare le nouvel acteur
                            $actor_ref = new Artist([
                                'name' => $actor,
                                'artist_url' => $actor_url
                            ]);

                            # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                            $serieInBDD->artists()->save($actor_ref, ['profession' => 'actor', 'role' => $actorRole]);
                        }

                    }
                }
            } else {
                Log::info('On passe la série '. $idSerie);
            }

        }
    }
}
