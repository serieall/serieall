<?php

namespace App\Jobs;

use App\Models\Channel;
use App\Models\Nationality;
use App\Models\Show;
use App\Models\Genre;
use App\Models\Artist;
use App\Models\Temp;
use App\Models\Season;
use App\Models\Episode;

use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Log;

use GuzzleHttp\Client;
use Illuminate\Support\Str;

class ShowAddFromTVDB extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $inputs;

    /**
     * Create a new job instance.
     *
     * @param $inputs
     */

    public function __construct($inputs)
    {
        $this->inputs = $inputs;
    }

    /**
     * @param $getEpisode_en
     * @param $idLog
     * @param $episodeID
     * @internal param $jobName
     */
    private function AddWritersDirectorsGuests($getEpisode_en, $idLog, $episodeID){
        $episode_new = Episode::where('thetvdb_id', $episodeID)->first();

        /*
        |--------------------------------------------------------------------------
        | Récupération des informations sur les guests de l'épisode
        |--------------------------------------------------------------------------
        | On crée les guests s'ils n'existent pas et on les lie à l'épisode
        */
        $guestStars = $getEpisode_en->guestStars;
        if (!empty($guestStars)) {
            $logMessage = '>>>>>GUESTS';
            saveLogMessage($idLog, $logMessage);

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
                    $logMessage = '>>>>>>Création du guest ' . $guestStar . '.';
                    saveLogMessage($idLog, $logMessage);
                    # On prépare le nouveau guest
                    $guestStar_ref = new Artist([
                        'name' => $guestStar,
                        'artist_url' => $guestStar_url
                    ]);

                    # Et on le sauvegarde ne passant par l'objet Episode pour créer le lien entre les deux
                    $episode_new->artists()->save($guestStar_ref, ['profession' => 'guest']);

                } else {
                    $logMessage = '>>>>>>Liaison du guest ' . $guestStar . '.';
                    saveLogMessage($idLog, $logMessage);
                    # Si il existe, on crée juste le lien
                    $episode_new->artists()->attach($guestStar_ref->id, ['profession' => 'guest']);
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
            $logMessage = '>>>>>REALISATEURS';
            saveLogMessage($idLog, $logMessage);

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
                    $logMessage = '>>>>>>Création du réalisateur ' . $director . '.';
                    saveLogMessage($idLog, $logMessage);
                    # On prépare le nouveau réal
                    $director_ref = new Artist([
                        'name' => $director,
                        'artist_url' => $director_url
                    ]);

                    # Et on le sauvegarde ne passant par l'objet Episode pour créer le lien entre les deux
                    $episode_new->artists()->save($director_ref, ['profession' => 'director']);

                } else {
                    $logMessage = '>>>>>>Liaison du réalisateur ' . $director . '.';
                    saveLogMessage($idLog, $logMessage);
                    # Si il existe, on crée juste le lien
                    $episode_new->artists()->attach($director_ref->id, ['profession' => 'director']);
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
            $logMessage = '>>>>>SCENARISTES';
            saveLogMessage($idLog, $logMessage);

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
                    $logMessage = '>>>>>>Création du scénariste ' . $writer . '.';
                    saveLogMessage($idLog, $logMessage);
                    # On prépare le nouveau scénariste
                    $writer_ref = new Artist([
                        'name' => $writer,
                        'artist_url' => $writer_url
                    ]);

                    # Et on le sauvegarde ne passant par l'objet Episode pour créer le lien entre les deux
                    $episode_new->artists()->save($writer_ref, ['profession' => 'writer']);

                } else {
                    $logMessage = '>>>>>>Liaison du scénariste ' . $writer . '.';
                    saveLogMessage($idLog, $logMessage);
                    # Si il existe, on crée juste le lien
                    $episode_new->artists()->attach($writer_ref->id, ['profession' => 'writer']);
                }
            }
        }
    }

    /**
     * @param $getEpisodes
     * @param $api_version
     * @param $token
     * @param $show_new
     * @param $idLog
     * @param $api_url
     * @internal param $jobName
     * @internal param $client
     */
    private function AddEpisodeOneByOne($getEpisodes, $api_version, $token, $show_new, $idLog, $api_url)
    {
        $client = new Client(['base_uri' => $api_url]);

        # Pour chaque épisode dans le paramètre getEpisodes
        foreach ($getEpisodes as $episode) {
            # On vérifie d'abord que la saison n'est pas à 0
            $seasonNumber = $episode->airedSeason;

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

            if ($seasonNumber != 0) {
                /*
                |--------------------------------------------------------------------------
                | Récupération des informations de la saison
                |--------------------------------------------------------------------------
                | On crée la saison si elle n'existe pas
                */
                # Variables de la saison
                # ID TheTVDB
                $seasonID = $getEpisode_en->airedSeasonID;

                # Numéro de la saison
                $seasonName = $getEpisode_en->airedSeason;

                # Vérification de la présence de la saison dans la BDD
                $season_ref = Season::where('thetvdb_id', $seasonID)->first();

                # Si elle n'existe pas
                if (is_null($season_ref)) {
                    $logMessage = '>>>SAISONS';
                    saveLogMessage($idLog, $logMessage);

                    $logMessage = '>>>>Création de la saison ' . $seasonName;
                    saveLogMessage($idLog, $logMessage);

                    # On prépare la nouvelle saison
                    $season_ref = new Season([
                        'name' => $seasonName,
                        'thetvdb_id' => $seasonID
                    ]);

                    # ID TheTVDB
                    $logMessage = '>>>>ID TheTVDB : ' . $seasonID;
                    saveLogMessage($idLog, $logMessage);

                    # Numéro de la saison
                    $logMessage = '>>>>Numéro : ' . $seasonName;
                    saveLogMessage($idLog, $logMessage);

                    # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $season_ref->show()->associate($show_new);
                    $season_ref->save();
                }

                /*
                |--------------------------------------------------------------------------
                | Récupération des informations de l'épisode
                |--------------------------------------------------------------------------
                | On crée l'épisode
                */

                $episode_new = new Episode();
                $episode_new->numero = $getEpisode_en->airedEpisodeNumber;

                $logMessage = '>>>>EPISODE ' . $seasonName . '.' . $episode_new->numero;
                saveLogMessage($idLog, $logMessage);

                $episode_new->thetvdb_id = $episodeID;
                # TheTVDB ID
                $logMessage = '>>>>>ID TheTVDB : ' . $episode_new->id;
                saveLogMessage($idLog, $logMessage);


                # Numéro
                $logMessage = '>>>>>Numéro : ' . $episode_new->numero;
                saveLogMessage($idLog, $logMessage);

                $episode_new->name = $getEpisode_en->episodeName;
                # Nom original de l'épisode
                $logMessage = '>>>>>Nom original de l\'épisode : ' . $episode_new->name;
                saveLogMessage($idLog, $logMessage);

                $episode_new->name_fr = $getEpisode_fr->episodeName;
                # Nom français de l\'épisode
                $logMessage = '>>>>>Nom français de l\'épisode : ' . $episode_new->name_fr;
                saveLogMessage($idLog, $logMessage);

                $episode_new->resume = $getEpisode_en->overview;
                # Résumé original
                $logMessage = '>>>>>Résumé original : ' . $episode_new->resume;
                saveLogMessage($idLog, $logMessage);

                $episode_new->resume_fr = $getEpisode_fr->overview;
                # Résumé original
                $logMessage = '>>>>>Résumé français : ' . $episode_new->resume_fr;
                saveLogMessage($idLog, $logMessage);

                $episode_new->diffusion_fr = $getEpisode_fr->firstAired;
                # Diffusion française
                $logMessage = '>>>>>Diffusion française : ' . $episode_new->diffusion_fr;
                saveLogMessage($idLog, $logMessage);

                $episode_new->diffusion_us = $getEpisode_en->firstAired;
                # Diffusion originale
                $logMessage = '>>>>>Diffusion originale : ' . $episode_new->diffusion_us;
                saveLogMessage($idLog, $logMessage);

                /* Récupération de la photo de l'épisode */
                if(!empty($getEpisode_en->filenam)) {
                    $file = "https://www.thetvdb.com/banners/" . $getEpisode_en->filename;
                    $file_headers = @get_headers($file);
                    if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                        $logMessage = '>>>Pas d\'image pour l\'épisode.';
                        saveLogMessage($idLog, $logMessage);
                    } else {
                        $episode_new->picture = "https://www.thetvdb.com/banners/" . $getEpisode_en->filename;
                        # Image
                        $logMessage = '>>>>>Image : ' . $episode_new->name_fr;
                        saveLogMessage($idLog, $logMessage);
                    }
                }

                # Et on le sauvegarde en passant par l'objet Season pour créer le lien entre les deux
                $episode_new->season()->associate($season_ref);
                $episode_new->save();

                # Ajout des informations sur les scénaristes, réalisateurs et guests
                $this->AddWritersDirectorsGuests($getEpisode_en, $idLog, $episodeID);
            }
            else{
                /*
                |--------------------------------------------------------------------------
                | Gestion des épisodes spéciaux
                |--------------------------------------------------------------------------
                | Si l'épisode est dans la saison 0 sur TheTVDB, c'est un épisode spécial.
                | Cependant, on ne va pas ajouter tous les épisodes spéciaux (genre les bonus DVD, on s'en fout
                | Du coup on ne va prendre que ceux qui ont le champ airsAfterSeason non nul
                */
                if(!is_null($getEpisode_en->airsAfterSeason)){
                    /*
                    |--------------------------------------------------------------------------
                    | Récupération des informations de la saison
                    |--------------------------------------------------------------------------
                    | On crée la saison si elle n'existe pas
                    */

                    # Variables de la saison
                    $seasonName = $getEpisode_en->airsAfterSeason;

                    # On récupère l'ID de la saison en question
                    $seasonID = Season::where('name', $seasonName)
                        ->where('show_id', $show_new->id)
                        ->first();
                    $seasonID = $seasonID->thetvdb_id;

                    # Vérification de la présence de la saison dans la BDD
                    $season_ref = Season::where('thetvdb_id', $seasonID)->first();

                    # Si elle n'existe pas
                    if (is_null($season_ref)) {
                        $logMessage = '>>>SAISONS';
                        saveLogMessage($idLog, $logMessage);

                        $logMessage = '>>>>Création de la saison ' . $seasonName;
                        saveLogMessage($idLog, $logMessage);

                        # On prépare la nouvelle saison
                        $season_ref = new Season([
                            'name' => $seasonName,
                            'thetvdb_id' => $seasonID
                        ]);

                        # ID TheTVDB
                        $logMessage = '>>>>ID TheTVDB : ' . $seasonID;
                        saveLogMessage($idLog, $logMessage);

                        # Numéro de la saison
                        $logMessage = '>>>>Numéro : ' . $seasonName;
                        saveLogMessage($idLog, $logMessage);

                        # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                        $season_ref->show()->associate($show_new);
                        $season_ref->save();
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Récupération des informations de l'épisode
                    |--------------------------------------------------------------------------
                    | On crée l'épisode
                    */

                    $episode_new = new Episode();
                    $episode_new->numero = 0;

                    $logMessage = '>>>>EPISODE ' . $seasonName . '.' . $episode_new->numero;
                    saveLogMessage($idLog, $logMessage);

                    $episode_new->thetvdb_id = $episodeID;
                    # TheTVDB ID
                    $logMessage = '>>>>>ID TheTVDB : ' . $episode_new->id;
                    saveLogMessage($idLog, $logMessage);


                    # Numéro
                    $logMessage = '>>>>>Numéro : ' . $episode_new->numero;
                    saveLogMessage($idLog, $logMessage);

                    $episode_new->name = $getEpisode_en->episodeName;
                    # Nom original de l'épisode
                    $logMessage = '>>>>>Nom original de l\'épisode : ' . $episode_new->name;
                    saveLogMessage($idLog, $logMessage);

                    $episode_new->name_fr = $getEpisode_fr->episodeName;
                    # Nom français de l\'épisode
                    $logMessage = '>>>>>Nom français de l\'épisode : ' . $episode_new->name_fr;
                    saveLogMessage($idLog, $logMessage);

                    $episode_new->resume = $getEpisode_en->overview;
                    # Résumé original
                    $logMessage = '>>>>>Résumé original : ' . $episode_new->resume;
                    saveLogMessage($idLog, $logMessage);

                    $episode_new->resume_fr = $getEpisode_fr->overview;
                    # Résumé original
                    $logMessage = '>>>>>Résumé français : ' . $episode_new->resume_fr;
                    saveLogMessage($idLog, $logMessage);

                    $episode_new->diffusion_fr = $getEpisode_fr->firstAired;
                    # Diffusion française
                    $logMessage = '>>>>>Diffusion française : ' . $episode_new->diffusion_fr;
                    saveLogMessage($idLog, $logMessage);

                    $episode_new->diffusion_us = $getEpisode_en->firstAired;
                    # Diffusion originale
                    $logMessage = '>>>>>Diffusion originale : ' . $episode_new->diffusion_us;
                    saveLogMessage($idLog, $logMessage);

                    $episode_new->picture = "https://www.thetvdb.com/banners/" . $getEpisode_en->filename;
                    # Image
                    $logMessage = '>>>>>Image : ' . $episode_new->name_fr;
                    saveLogMessage($idLog, $logMessage);

                    # Et on le sauvegarde en passant par l'objet Season pour créer le lien entre les deux
                    $episode_new->season()->associate($season_ref);
                    $episode_new->save();

                    # Ajout des informations sur les scénaristes, réalisateurs et guests
                    $this->AddWritersDirectorsGuests($getEpisode_en, $idLog, $episodeID);
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
        | Initialisation du job
        |--------------------------------------------------------------------------
        */
        $idLog = initJob($this->inputs['user_id'], 'Ajout via TVDB', 'Show', $this->inputs['thetvdb_id']);
        
        /*
        |--------------------------------------------------------------------------
        | Définition des variables
        |--------------------------------------------------------------------------
        */
        $theTVDBID = $this->inputs['thetvdb_id'];
        $key_token = "token";
        $api_key = config('thetvdb.apikey');
        $api_username = config('thetvdb.username');
        $api_userkey = config('thetvdb.userkey');
        $api_url = config('thetvdb.url');
        $api_version = config('thetvdb.version');
        $hours_duration_token = config('thetvdb.hoursduration');
        $public = public_path();

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
        else{
            # Sinon, on utilise celui en base
            $token = $keyToken->value;
        }

        /*
        |--------------------------------------------------------------------------
        | Recupération de la série en français et avec la langue par défaut
        |--------------------------------------------------------------------------
        | Le paramètre passé est l'ID de TheTVDB passé dans le formulaire
        | On précise la version de l'API a utiliser, que l'on veut recevoir du JSON.
        | On passe également en paramètre le token.
        */
        $getShow_fr = $client->request('GET', '/series/'. $theTVDBID, [
            'headers' => [
                'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                'Authorization' => 'Bearer ' . $token,
                'Accept-Language' => 'fr',
            ]
        ])->getBody();

        $getShow_en = $client->request('GET', '/series/'. $theTVDBID, [
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

        /*
        |--------------------------------------------------------------------------
        | Création de la série
        |--------------------------------------------------------------------------
        | On commence par créer l'objet qui contiendra toutes les informations de
        | la série à créer, basé sur le Model 'Show'.
        | On définit les valeurs des différents champs voulus
        | On crée l'objet en base.
        */
        $show_new = new Show();
        $logMessage = '>SERIE';
        saveLogMessage($idLog, $logMessage);

        $show_new->thetvdb_id = $theTVDBID;
        # Diffusion originale
        $logMessage = '>>ID TheTVDB : ' . $show_new->thetvdb_id;
        saveLogMessage($idLog, $logMessage);

        if(empty($show_en->seriesName)){
            $show_en->seriesName = $show_fr->seriesName;
        }

        $show_new->name = $show_en->seriesName;
        # Nom original de la série
        $logMessage = '>>Nom original : ' . $show_new->name;
        saveLogMessage($idLog, $logMessage);

        $show_new->name_fr = $show_fr->seriesName;
        # Nom français de la série
        $logMessage = '>>Nom français : ' . $show_new->name_fr;
        saveLogMessage($idLog, $logMessage);

        $show_new->synopsis = $show_en->overview;
        # Résumé de la série
        $logMessage = '>>Résumé original : ' . $show_new->synopsis;
        saveLogMessage($idLog, $logMessage);

        $show_new->synopsis_fr = $show_fr->overview;
        # Résumé français de la série
        $logMessage = '>>Résumé français : ' . $show_new->synopsis_fr;
        saveLogMessage($idLog, $logMessage);

        $show_new->diffusion_us = $show_en->firstAired;
        # Diffusion originale
        $logMessage = '>>Diffusion originale : ' . $show_new->diffusion_us;
        saveLogMessage($idLog, $logMessage);

        $show_new->diffusion_fr = $this->inputs['diffusion_fr'];
        # Diffusion française
        $logMessage = '>>Diffusion française : ' . $show_new->diffusion_fr;
        saveLogMessage($idLog, $logMessage);

        $show_new->format = $show_en->runtime;
        # Format
        $logMessage = '>>Format : ' . $show_new->format;
        saveLogMessage($idLog, $logMessage);

        $show_new->taux_erectile = $this->inputs['taux_erectile'];
        # Taux Erectile
        $logMessage = '>>Taux Erectile : ' . $show_new->taux_erectile;
        saveLogMessage($idLog, $logMessage);

        $show_new->avis_rentree = $this->inputs['avis_rentree'];
        # Format
        $logMessage = '>>Avis Rentrée : ' . $show_new->avis_rentree;
        saveLogMessage($idLog, $logMessage);

        if ($show_en->status == 'Continuing'){
            $show_new->encours = 1;
        }
        else
        {
            $show_new->encours = 0;
        }
        # En Cours
        $logMessage = '>>En cours : ' . $show_new->encours;
        saveLogMessage($idLog, $logMessage);

        $dateTemp = date_create($show_en->firstAired);
        $show_new->annee = date_format($dateTemp, "Y");
        # Année
        $logMessage = '>>Année : ' . $show_new->annee;
        saveLogMessage($idLog, $logMessage);

        $show_new->show_url = Str::slug($show_new->name);
        # URL
        $logMessage = '>>URL : ' . $show_new->show_url;
        saveLogMessage($idLog, $logMessage);

        $show_new->save();

        /* Récupération de l'affiche de la série
         */
        $file = 'http://www.thetvdb.com/banners/posters/'. $show_new->thetvdb_id . '-1.jpg';
        $file_headers = @get_headers($file);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[8] == 'HTTP/1.1 404 Not Found') {
            $logMessage = '>>Pas d\'image pour la série.';
            saveLogMessage($idLog, $logMessage);
        }
        else {
            copy($file, $public . '/images/shows/' . $show_new->show_url . '.jpg');
            $logMessage = '>>Image pour la série récupérée.';
            saveLogMessage($idLog, $logMessage);
        }

        /*
        |--------------------------------------------------------------------------
        | Gestion des genres
        |--------------------------------------------------------------------------
        | On commence par récupérer les genres de The TVDB
        | Puis on les ajoute si ils n'existe pas dans la base
        | S'il existe on crée juste le lien avec la série
        */

        $genres = $show_en->genre;
        $logMessage = '>>GENRES';
        saveLogMessage($idLog, $logMessage);

        if(!empty($genres)) {
            # Pour chaque genre
            foreach ($genres as $genre) {
                # On supprime les espaces
                $genre = trim($genre);
                # On met en forme l'URL
                $genre_url = Str::slug($genre);
                # On vérifie si le genre existe déjà en base
                $genre_ref = Genre::where('genre_url', $genre_url)->first();

                # Si il n'existe pas
                if (is_null($genre_ref)) {
                    $logMessage = '>>>Ajout du genre ' . $genre . '.';
                    saveLogMessage($idLog, $logMessage);
                    # On prépare le nouveau genre
                    $genre_ref = new Genre([
                        'name' => $genre,
                        'genre_url' => $genre_url
                    ]);

                    # Et on le sauvegarde ne passant par l'objet Show pour créer le lien entre les deux
                    $show_new->genres()->save($genre_ref);

                } else {
                    $logMessage = '>>>Liaison du genre ' . $genre . '.';
                    saveLogMessage($idLog, $logMessage);
                    # Si il existe, on crée juste le lien
                    $show_new->genres()->attach($genre_ref->id);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Gestion des créateurs
        |--------------------------------------------------------------------------
        | On commence par récupérer les créateurs du formulaire
        | Et on formate le tout et on applique le même traitement que pour les genres
        */
        $creators = $this->inputs['creators'];
        $logMessage = '>>CREATEURS';
        saveLogMessage($idLog, $logMessage);

        if(!empty($creators)) {
            $creators = explode(',', $creators);

            # Pour chaque créateur
            foreach ($creators as $creator) {
                # On supprime les espaces
                $creator = trim($creator);
                # On met en forme l'URL
                $creator_url = Str::slug($creator);
                # On vérifie si le genre existe déjà en base
                $creator_ref = Artist::where('artist_url', $creator_url)->first();

                # Si il n'existe pas
                if (is_null($creator_ref)) {
                    $logMessage = '>>Ajout du créateur ' . $creator . '.';
                    saveLogMessage($idLog, $logMessage);
                    # On prépare le nouveau créateur
                    $creator_ref = new Artist([
                        'name' => $creator,
                        'artist_url' => $creator_url
                    ]);

                    # Et on le sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $show_new->artists()->save($creator_ref, ['profession' => 'creator']);
                } else {
                    $logMessage = '>>Liaison du créateur ' . $creator . '.';
                    saveLogMessage($idLog, $logMessage);
                    # Si il existe, on crée juste le lien
                    $show_new->artists()->attach($creator_ref->id, ['profession' => 'creator']);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Gestion des nationalités
        |--------------------------------------------------------------------------
        | On commence par récupérer les nationalités du formulaire
        | Et on formate le tout et on applique le même traitement que pour les genres
        */
        $nationalities = $this->inputs['nationalities'];
        $logMessage = '>>NATIONALITES';
        saveLogMessage($idLog, $logMessage);

        if(!empty($nationalities)) {
            $nationalities = explode(',', $nationalities);

            # Pour chaque nationalité
            foreach ($nationalities as $nationality) {
                # On supprime les espaces
                $nationality = trim($nationality);
                # On met en forme l'URL
                $nationality_url = Str::slug($nationality);
                # On vérifie si la nationalité existe déjà en base
                $nationality_ref = Nationality::where('nationality_url', $nationality_url)->first();

                # Si elle n'existe pas
                if (is_null($nationality_ref)) {
                    $logMessage = '>>>Ajout de la nationalité ' . $nationality . '.';
                    saveLogMessage($idLog, $logMessage);
                    # On prépare la nouvelle nationalité
                    $nationality_ref = new Nationality([
                        'name' => $nationality,
                        'nationality_url' => $nationality_url
                    ]);

                    # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $show_new->nationalities()->save($nationality_ref);
                } else {
                    $logMessage = '>>>Liaison de la nationalité ' . $nationality . '.';
                    saveLogMessage($idLog, $logMessage);
                    # Si elle existe, on crée juste le lien
                    $show_new->nationalities()->attach($nationality_ref->id);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Gestion des chaines
        |--------------------------------------------------------------------------
        | On commence par récupérer les chaines du formulaire et on les concatène avec la chaine de base
        | Et on formate le tout et on applique le même traitement que pour les genres
        */
        # Si le formulaire n'a pas été rempli pour la partie chaine fr
        if(empty($this->inputs['chaine_fr'])){
            $channels = $show_en->network;
        }
        else {
            $channels = $show_en->network . ',' . $this->inputs['chaine_fr'];
        }

        if(!empty($channels)) {
            $channels = explode(',', $channels);
            $logMessage = '>>CHAINES';
            saveLogMessage($idLog, $logMessage);

            # Pour chaque chaines
            foreach ($channels as $channel) {
                # On supprime les espaces
                $channel = trim($channel);
                # On met en forme l'URL
                $channel_url = Str::slug($channel);
                # On vérifie si la nationalité existe déjà en base
                $channel_ref = Channel::where('channel_url', $channel_url)->first();

                # Si elle n'existe pas
                if (is_null($channel_ref)) {
                    $logMessage = '>>>Ajout de la chaine ' . $channel . '.';
                    saveLogMessage($idLog, $logMessage);
                    # On prépare la nouvelle nationalité
                    $channel_ref = new Channel([
                        'name' => $channel,
                        'channel_url' => $channel_url
                    ]);

                    # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $show_new->channels()->save($channel_ref);
                } else {
                    $logMessage = '>>>Liaison de la chaine ' . $channel . '.';
                    saveLogMessage($idLog, $logMessage);
                    # Si elle existe, on crée juste le lien
                    $show_new->channels()->attach($channel_ref->id);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Gestion des acteurs
        |--------------------------------------------------------------------------
        | On commence par récupérer les chaines du formulaire
        */
        $getActors = $client->request('GET', '/series/'. $theTVDBID . '/actors', [
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
            $logMessage = '>>ACTEURS';
            foreach ($actors as $actor) {
                saveLogMessage($idLog, $logMessage);
                # Récupération du nom de l'acteur
                $actorName = $actor->name;

                # Récupération de l'ID de l'acteur pour l'image (ID non stocké)
                $actorID = $actor->id;

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

                # Si elle n'existe pas
                if (is_null($actor_ref)) {
                    $logMessage = '>>>Création de l\'acteur ' . $actorName . '.';
                    saveLogMessage($idLog, $logMessage);
                    # On prépare le nouvel acteur
                    $actor_ref = new Artist([
                        'name' => $actor,
                        'artist_url' => $actor_url
                    ]);

                    # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $show_new->artists()->save($actor_ref, ['profession' => 'actor', 'role' => $actorRole]);

                    /* Récupération de la photo de l'acteur */
                    $file = 'https://www.thetvdb.com/banners/actors/' . $actorID . '.jpg';
                    $file_headers = @get_headers($file);
                    if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                        $logMessage = '>>>Pas d\'image pour l\'acteur '. $actorName . '.';
                        saveLogMessage($idLog, $logMessage);
                    }
                    else {
                        copy($file, $public . '/images/actors/' . $actor_ref->artist_url . '.jpg');
                        $logMessage = '>>>Image pour l\'acteur '. $actorName . ' récupérée.';
                        saveLogMessage($idLog, $logMessage);
                    }
                } else {
                    $logMessage = '>>>Liaison de l\'acteur ' . $actorName . '.';
                    saveLogMessage($idLog, $logMessage);
                    # Si il existe, on crée juste le lien
                    $show_new->artists()->attach($actor_ref->id, ['profession' => 'actor', 'role' => $actorRole]);
                }
            }
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
            $this->AddEpisodeOneByOne($getEpisodes, $api_version, $token, $show_new, $idLog, $api_url);
        }
        else{
            $logMessage = '>>>En cours, page n°1';
            saveLogMessage($idLog, $logMessage);

            $this->AddEpisodeOneByOne($getEpisodes, $api_version, $token, $show_new, $idLog, $api_url);

            while($getEpisodeNextPage <= $getEpisodeLastPage) {
                $logMessage = 'En cours, page n°'.$getEpisodeNextPage;
                saveLogMessage($idLog, $logMessage);

                $getEpisodes_en = $client->request('GET', '/series/' . $theTVDBID .'/episodes?page='. $getEpisodeNextPage, [
                    'headers' => [
                        'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                        'Authorization' => 'Bearer ' . $token,
                        'Accept-Language' => 'en',
                    ]
                ])->getBody();

                $getEpisodes_en = json_decode($getEpisodes_en);
                $getEpisodes = $getEpisodes_en->data;

                $this->AddEpisodeOneByOne($getEpisodes, $api_version, $token, $show_new, $idLog, $api_url);
                $getEpisodeNextPage++;
            }
        }

        endJob($idLog);
    }
}
