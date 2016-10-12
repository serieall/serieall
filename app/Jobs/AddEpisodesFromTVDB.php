<?php

namespace App\Jobs;


use App\Models\Artist;
use App\Models\Episode;
use App\Models\Temp;
use App\Models\Season;

use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use GuzzleHttp\Client;
use Carbon\Carbon;
use \Illuminate\Support\Str;

class AddEpisodesFromTVDB extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $thetvdb_id_show;
    protected $show_new;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($thetvdb_id_show, $show_new)
    {
        $this->thetvdb_id_show = $thetvdb_id_show;
        $this->show_new = $show_new;
    }

    /**
     * Add new seasons and episodes
     *
     * @return void
     */
    private function AddEpisodeOneByOne($client, $getEpisodes, $api_version, $token, $show_new)
    {
        # Pour chaque épisode dans le paramètre getEpisodes
        foreach ($getEpisodes as $episode) {
            # On vérifie d'abord que la saison n'est pas à 0
            $seasonNumber = $episode->airedSeason;

            if ($seasonNumber != 0) {

                # On récupère l'ID de l'épisode
                $episodeID = $episode->id;

                /*
                |--------------------------------------------------------------------------
                | Récupération des informations de l'épisode en question
                |--------------------------------------------------------------------------
                | Dans un premier temps, en français.
                | Puis en anglais et on vérifie que le français est bien rempli, sinon on
                | choisit la version anglaise.
                */
                $getEpisode_fr = $client->request('GET', '/episodes/' . $episodeID, [
                    'headers' => [
                        'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                        'Authorization' => 'Bearer ' . $token,
                        'Accept-Language' => 'fr',
                    ]
                ])->getBody();

                $getEpisode_en = $client->request('GET', '/episodes/' . $episodeID, [
                    'headers' => [
                        'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                        'Authorization' => 'Bearer ' . $token,
                        'Accept-Language' => 'en',
                    ]
                ])->getBody();

                # On décode le JSON
                $getEpisode_fr = json_decode($getEpisode_fr);
                $getEpisode_en = json_decode($getEpisode_en);

                $getEpisode_en = $getEpisode_en->data;
                $getEpisode_fr = $getEpisode_fr->data;


                /*
                |--------------------------------------------------------------------------
                | Récupération des informations de la saison
                |--------------------------------------------------------------------------
                | On crée la saison si elle n'existe pas
                */
                # Variables de la saison
                $seasonID = $getEpisode_en->airedSeasonID;
                $seasonName = $getEpisode_en->airedSeason;

                # Vérification de la présence de la saison dans la BDD
                $season_ref = Season::where('thetvdb_id', $seasonID)->first();

                # Si elle n'existe pas
                if (is_null($season_ref)) {
                    # On prépare la nouvelle saison
                    $season_ref = new Season([
                        'name' => $seasonName,
                        'thetvdb_id' => $seasonID
                    ]);

                    # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $season_ref->show()->associate($show_new);
                    $season_ref->save();
                } else {
                    $season_ref->show()->associate($show_new);
                }

                /*
                |--------------------------------------------------------------------------
                | Récupération des informations de l'épisode
                |--------------------------------------------------------------------------
                | On crée l'épisode si elle n'existe pas
                */

                # Vérification de la présence de l'épisode dans la BDD
                $episode_ref = Episode::where('thetvdb_id', $episodeID)->first();

                # Si il n'existe pas
                if (is_null($episode_ref)) {
                    # Variables de l'épisode
                    $episodeNumero = $getEpisode_en->airedEpisodeNumber;

                    # Nom de l'épisode (s'il n'existe pas on met le nom par défaut
                    $episodeName = $getEpisode_en->episodeName;
                    if (is_null($episodeName)) {
                        $episodeName = 'TBA';
                    }

                    # Date de diffusion US. Si elle n'existe pas, on met la date par défaut
                    $episodeDiffusionUS = $getEpisode_en->firstAired;
                    if (is_null($episodeDiffusionUS)) {
                        $episodeDiffusionUS = '1970-01-01';
                    }

                    # Nom FR, sil n'existe pas, on en met pas
                    $episodeNameFR = $getEpisode_fr->episodeName;
                    if (is_null($episodeNameFR)) {
                        $episodeNameFR = 'TBA';
                    }

                    # Résumé, si pas de version française, on met la version anglaise, et sinon on met le résumé par défaut
                    $episodeResume = $getEpisode_fr->overview;
                    if (is_null($episodeResume)) {
                        $episodeResume = $getEpisode_en->overview;
                        if (is_null($episodeResume)) {
                            $episodeResume = 'Pas de résumé pour l\'instant.';
                        }
                    }

                    # On prépare le nouvel épisode
                    $episode_ref = new Episode([
                        'numero' => $episodeNumero,
                        'name' => $episodeName,
                        'name_fr' => $episodeNameFR,
                        'thetvdb_id' => $episodeID,
                        'resume' => $episodeResume,
                        'diffusion_us' => $episodeDiffusionUS,
                    ]);
                    # Et on le sauvegarde en passant par l'objet Season pour créer le lien entre les deux
                    $episode_ref->season()->associate($season_ref);
                    $episode_ref->save();
                } else {
                    $episode_ref->season()->associate($season_ref);
                }

                /*
                |--------------------------------------------------------------------------
                | Récupération des informations sur les guests de l'épisode
                |--------------------------------------------------------------------------
                | On crée les guests s'ils n'existent pas et on les lie à l'épisode
                */
                $guestStars = $getEpisode_en->guestStars;
                if (!empty($guestStars)) {
                    # Pour chaque guest
                    foreach ($guestStars as $guestStar) {
                        # On supprime les espaces
                        $guestStar = trim($guestStar);
                        # On met en forme l'URL
                        $guestStar_url = Str::slug($guestStar);
                        # On vérifie si le guest existe déjà en base
                        $guestStar_ref = Artist::where('artist_url', $guestStar_url)->first();

                        # Si il n'existe pas
                        if (is_null($guestStar_ref)) {
                            # On prépare le nouveau guest
                            $guestStar_ref = new Artist([
                                'name' => $guestStar,
                                'artist_url' => $guestStar_url
                            ]);

                            # Et on le sauvegarde ne passant par l'objet Episode pour créer le lien entre les deux
                            $episode_ref->artists()->save($guestStar_ref, ['profession' => 'guest']);

                        } else {
                            # Si il existe, on crée juste le lien
                            $episode_ref->artists()->attach($guestStar_ref->id, ['profession' => 'guest']);
                        }
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Récupération des informations sur les réalisateurs de l'épisode
                |--------------------------------------------------------------------------
                | On crée les réals s'ils n'existent pas et on les lie à l'épisode
                */
                $directors = $getEpisode_en->directors;
                if (!empty($directors)) {
                    # Pour chaque réal
                    foreach ($directors as $director) {
                        # On supprime les espaces
                        $director = trim($director);
                        # On met en forme l'URL
                        $director_url = Str::slug($director);
                        # On vérifie si le réal existe déjà en base
                        $director_ref = Artist::where('artist_url', $director_url)->first();

                        # Si il n'existe pas
                        if (is_null($director_ref)) {
                            # On prépare le nouveau réal
                            $director_ref = new Artist([
                                'name' => $director,
                                'artist_url' => $director_url
                            ]);

                            # Et on le sauvegarde ne passant par l'objet Episode pour créer le lien entre les deux
                            $episode_ref->artists()->save($director_ref, ['profession' => 'director']);

                        } else {
                            # Si il existe, on crée juste le lien
                            $episode_ref->artists()->attach($director_ref->id, ['profession' => 'director']);
                        }
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Récupération des informations sur les scénaristes de l'épisode
                |--------------------------------------------------------------------------
                | On crée les scénaristes s'ils n'existent pas et on les lie à l'épisode
                */
                $writers = $getEpisode_en->writers;
                if (!empty($writers)) {
                    # Pour chaque scénariste
                    foreach ($writers as $writer) {
                        # On supprime les espaces
                        $writer = trim($writer);
                        # On met en forme l'URL
                        $writer_url = Str::slug($writer);
                        # On vérifie si le scénariste existe déjà en base
                        $writer_ref = Artist::where('artist_url', $writer_url)->first();

                        # Si il n'existe pas
                        if (is_null($writer_ref)) {
                            # On prépare le nouveau scénariste
                            $writer_ref = new Artist([
                                'name' => $writer,
                                'artist_url' => $writer_url
                            ]);

                            # Et on le sauvegarde ne passant par l'objet Episode pour créer le lien entre les deux
                            $episode_ref->artists()->save($writer_ref, ['profession' => 'writer']);

                        } else {
                            # Si il existe, on crée juste le lien
                            $episode_ref->artists()->attach($writer_ref->id, ['profession' => 'writer']);
                        }
                    }
                }
            }
        }
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
        $theTVDBID = $this->thetvdb_id_show;
        $key_token = "token";
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
        if($resetToken > $hours_duration_token){
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
        }
        else {
            # Sinon, on utilise celui en base
            $token = $keyToken->value;
        }

        /*
        |--------------------------------------------------------------------------
        | Recupération des saison/épisodes de la série
        |--------------------------------------------------------------------------
        | Le paramètre passé est l'ID de TheTVDB passé dans le formulaire
        | On précise la version de l'API a utiliser, que l'on veut recevoir du JSON.
        | On passe également en paramètre le token.
        */
        $getEpisodes_en = $client->request('GET', '/series/' . $theTVDBID .'/episodes?page=1', [
            'headers' => [
                'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                'Authorization' => 'Bearer ' . $token,
                'Accept-Language' => 'en',
            ]
        ])->getBody();

        /*
        |--------------------------------------------------------------------------
        | Décodage du JSON
        |--------------------------------------------------------------------------
        */
        $getEpisodes_en = json_decode($getEpisodes_en);

        /*
        |--------------------------------------------------------------------------
        | Récupération des variables sur le nombre de pages du JSON de la liste des épisodes
        |--------------------------------------------------------------------------
        */
        $getEpisodeNextPage = $getEpisodes_en->links->next;
        $getEpisodeLastPage = $getEpisodes_en->links->last;
        $getEpisodes = $getEpisodes_en->data;

        /*
        |--------------------------------------------------------------------------
        | Exécution de la récupération des informations de l'épisode
        |--------------------------------------------------------------------------
        | S'il n'y a pas de Page 'Next', on se cantonne à une seule, et on execute la fonction de récupération des
        | informations.
        | S'il y a plusieurs pages, pour chaque page, on lance une nouvelle récupération des informations pour chaque
        | page et on exécute la fonction de récupération des informations.
        */
        if(is_null($getEpisodeNextPage)){
            $this->AddEpisodeOneByOne($client, $getEpisodes, $api_version, $token, $this->show_new);
        }
        else{
            Log::info('En cours, page n°1 ');
            $this->AddEpisodeOneByOne($client, $getEpisodes, $api_version, $token, $this->show_new);

            while($getEpisodeNextPage <= $getEpisodeLastPage) {
                Log::info('En cours, page n° '.$getEpisodeNextPage);
                $getEpisodes_en = $client->request('GET', '/series/' . $theTVDBID .'/episodes?page='. $getEpisodeNextPage, [
                    'headers' => [
                        'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                        'Authorization' => 'Bearer ' . $token,
                        'Accept-Language' => 'en',
                    ]
                ])->getBody();

                $getEpisodes_en = json_decode($getEpisodes_en);
                $getEpisodes = $getEpisodes_en->data;

                $this->AddEpisodeOneByOne($client, $getEpisodes, $api_version, $token, $this->show_new);
                $getEpisodeNextPage++;
            }
        }
    }
}
