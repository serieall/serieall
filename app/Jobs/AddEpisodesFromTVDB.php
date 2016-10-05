<?php

namespace App\Jobs;


use App\Models\Artist;
use App\Models\Episode;
use App\Models\Temp;
use App\Models\Season;

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
    private function getEpisodeOneByOne($client, $getEpisodes, $api_version, $token, $show_new){
        # Pour chaque épisode dans le paramètre getEpisodes
        foreach($getEpisodes as $episode){
            # On vérifie d'abord que la saison n'est pas à 0
            $seasonNumber = $episode->airedSeason;

            if($seasonNumber != 0) {

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
                    $show_new->seasons()->save($season_ref);
                } else {
                    $show_new->seasons()->sync($season_ref);
                }

                # Récupération de l'objet saison pour l'épisode en cours
                $seasonEpisode = Season::where('thetvdb_id', $seasonID)->first();
                # Vérification de la présence de l'épisode dans la BDD
                $episode_ref = Episode::where('thetvdb_id', $episodeID)->first();

                # Si il n'existe pas
                if (is_null($episode_ref)) {
                    # Variables de l'épisode
                    $episodeName = $getEpisode_en->episodeName;
                    $episodeNumero = $getEpisode_en->airedEpisodeNumber;
                    $episodeDiffusionUS = $getEpisode_en->firstAired;

                    if (!is_null($getEpisode_fr->episodeName)) {
                        $episodeNameFR = $getEpisode_fr->episodeName;
                    } else {
                        $episodeNameFR = null;
                    }
                    if (!is_null($getEpisode_fr->overview)) {
                        $episodeResume = $getEpisode_fr->overview;
                    } else {
                        $episodeResume = $getEpisode_en->overview;
                    }

                    if(is_null($episodeNameFR)) {
                        # On prépare le nouvel épisode
                        $episode_ref = new Episode([
                            'numero' => $episodeNumero,
                            'name' => $episodeName,
                            'thetvdb_id' => $episodeID,
                            'resume' => $episodeResume,
                            'diffusion_us' => $episodeDiffusionUS,
                        ]);
                    } else {
                        # On prépare le nouvel épisode
                        $episode_ref = new Episode([
                            'numero' => $episodeNumero,
                            'name' => $episodeName,
                            'name_fr' => $episodeNameFR,
                            'thetvdb_id' => $episodeID,
                            'resume' => $episodeResume,
                            'diffusion_us' => $episodeDiffusionUS,

                        ]);
                    }

                    # Et on le sauvegarde en passant par l'objet Season pour créer le lien entre les deux
                    $seasonEpisode->episodes()->save($episode_ref);
                } else {
                    $seasonEpisode->episodes()->sync($episode_ref);
                }

                $episode_ref = Episode::where('thetvdb_id', $episodeID)->first();
                $guestStars = $episode->guestStars;

                if(!empty($guestStars)) {
                    # Pour chaque genre
                    foreach ($guestStars as $guestStar) {
                        # On supprime les espaces
                        $guestStar = trim($guestStar);
                        # On met en forme l'URL
                        $guestStar_url = Str::slug($guestStar);
                        # On vérifie si le genre existe déjà en base
                        $guestStar_ref = Artist::where('artist_url', $guestStar_url)->first();

                        # Si il n'existe pas
                        if (is_null($guestStar_ref)) {
                            # On prépare le nouveau genre
                            $guestStar_ref = new Artist([
                                'name' => $guestStar,
                                'artist_url' => $guestStar_url
                            ]);

                            # Et on le sauvegarde ne passant par l'objet Show pour créer le lien entre les deux
                            $episode_ref->artists()->save($guestStar_ref, ['profession' => 'guest']);

                        } else {
                            # Si il existe, on crée juste le lien
                            $episode_ref->artists()->sync($guestStar_ref->id, ['profession' => 'guest']);
                        }
                    }
                }

                $directors = $episode->directors;

                if(!empty($directors)) {
                    # Pour chaque genre
                    foreach ($directors as $director) {
                        # On supprime les espaces
                        $director = trim($director);
                        # On met en forme l'URL
                        $director_url = Str::slug($director);
                        # On vérifie si le genre existe déjà en base
                        $director_ref = Artist::where('artist_url', $director_url)->first();

                        # Si il n'existe pas
                        if (is_null($director_ref)) {
                            # On prépare le nouveau genre
                            $director_ref = new Artist([
                                'name' => $director,
                                'artist_url' => $director_url
                            ]);

                            # Et on le sauvegarde ne passant par l'objet Show pour créer le lien entre les deux
                            $episode_ref->artists()->save($director_ref, ['profession' => 'director']);

                        } else {
                            # Si il existe, on crée juste le lien
                            $episode_ref->artists()->sync($director_ref->id, ['profession' => 'director']);
                        }
                    }
                }

                $writers = $episode->writers;

                if(!empty($writers)) {
                    # Pour chaque genre
                    foreach ($writers as $writer) {
                        # On supprime les espaces
                        $writer = trim($writer);
                        # On met en forme l'URL
                        $writer_url = Str::slug($writer);
                        # On vérifie si le genre existe déjà en base
                        $writer_ref = Artist::where('artist_url', $writer_url)->first();

                        # Si il n'existe pas
                        if (is_null($writer_ref)) {
                            # On prépare le nouveau genre
                            $writer_ref = new Artist([
                                'name' => $writer,
                                'artist_url' => $writer_url
                            ]);

                            # Et on le sauvegarde ne passant par l'objet Show pour créer le lien entre les deux
                            $episode_ref->artists()->save($writer_ref, ['profession' => 'director']);

                        } else {
                            # Si il existe, on crée juste le lien
                            $episode_ref->artists()->sync($writer_ref->id, ['profession' => 'director']);
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
        $getEpisodes_fr = $client->request('GET', '/series/' . $theTVDBID .'/episodes', [
            'headers' => [
                'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                'Authorization' => 'Bearer ' . $token,
                'Accept-Language' => 'fr',
            ]
        ])->getBody();

        $getEpisodes_en = $client->request('GET', '/series/' . $theTVDBID .'/episodes', [
            'headers' => [
                'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                'Authorization' => 'Bearer ' . $token,
                'Accept-Language' => 'en',
            ]
        ])->getBody();

        /*
        |--------------------------------------------------------------------------
        | Décodage du JSON et vérification que la langue française existe sur The TVDB
        | Si la langue fr n'est pas renseignée, on prends la langue anglaise
        |--------------------------------------------------------------------------
        */
        $getEpisodes_fr = json_decode($getEpisodes_fr);
        $getEpisodes_en = json_decode($getEpisodes_en);

        if (isset($getEpisodes_fr->errors->invalidLanguage)){
            $getEpisodeNextPage = $getEpisodes_en->links->next;
            $getEpisodeLastPage = $getEpisodes_en->links->last;
            $getEpisodes = $getEpisodes_en->data;
        }
        else{
            $getEpisodeNextPage = $getEpisodes_fr->links->next;
            $getEpisodeLastPage = $getEpisodes_fr->links->last;
            $getEpisodes = $getEpisodes_fr->data;
        }

        if(is_null($getEpisodeNextPage)){
            $this->getEpisodeOneByOne($client, $getEpisodes, $api_version, $token, $this->show_new);
        }
        else{
            $this->getEpisodeOneByOne($client, $getEpisodes, $api_version, $token, $this->show_new);

            while($getEpisodeNextPage < $getEpisodeLastPage) {
                $getEpisodes_en = $client->request('GET', '/series/' . $theTVDBID .'/episodes?page='. $getEpisodeNextPage, [
                    'headers' => [
                        'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                        'Authorization' => 'Bearer ' . $token,
                        'Accept-Language' => 'en',
                    ]
                ])->getBody();

                $getEpisodes_en = json_decode($getEpisodes_en);

                $getEpisodeNextPage = $getEpisodes_en->links->next;
                $getEpisodeLastPage = $getEpisodes_en->links->last;
                $getEpisodes = $getEpisodes_en->data;

                $this->getEpisodeOneByOne($client, $getEpisodes, $api_version, $token, $this->show_new);

                $getEpisodeNextPage++;
            }
        }
    }
}
