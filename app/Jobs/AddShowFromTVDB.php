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

use GuzzleHttp\Client;
use \Illuminate\Support\Str;

class AddShowFromTVDB extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $inputs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($inputs)
    {
        $this->inputs = $inputs;
    }

    private function AddEpisodeOneByOne($client, $getEpisodes, $api_version, $token, $show_new, $jobName)
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
                    $logMessage = '** Création de la saison ' . $seasonName . ' **';
                    saveLogMessage($jobName, $logMessage);
                    # On prépare la nouvelle saison
                    $season_ref = new Season([
                        'name' => $seasonName,
                        'thetvdb_id' => $seasonID
                    ]);

                    # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $season_ref->show()->associate($show_new);
                    $season_ref->save();
                } else {
                    $logMessage = 'Liaison de la saison ' . $seasonName . '.';
                    saveLogMessage($jobName, $logMessage);
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

                    $logMessage = '** Création de l\'épisode ' . $seasonName . 'x' . $episodeNumero . ' **';
                    saveLogMessage($jobName, $logMessage);

                    # Nom de l'épisode (s'il n'existe pas on met le nom par défaut
                    $episodeName = $getEpisode_en->episodeName;
                    if (is_null($episodeName)) {
                        $logMessage = 'Pas de nom EN de l\'épisode';
                        saveLogMessage($jobName, $logMessage);
                        $episodeName = 'TBA';
                    }

                    # Date de diffusion US. Si elle n'existe pas, on met la date par défaut
                    $episodeDiffusionUS = $getEpisode_en->firstAired;
                    if (is_null($episodeDiffusionUS)) {
                        $logMessage = 'Pas de diffusion US de l\'épisode';
                        saveLogMessage($jobName, $logMessage);
                        $episodeDiffusionUS = '1800-01-01';
                    }

                    # Nom FR, sil n'existe pas, on en met pas
                    $episodeNameFR = $getEpisode_fr->episodeName;
                    if (is_null($episodeNameFR)) {
                        $logMessage = 'Pas de nom FR de l\'épisode';
                        saveLogMessage($jobName, $logMessage);
                        $episodeNameFR = 'TBA';
                    }

                    # Résumé, si pas de version française, on met la version anglaise, et sinon on met le résumé par défaut
                    $episodeResume = $getEpisode_fr->overview;
                    if (is_null($episodeResume)) {
                        $episodeResume = $getEpisode_en->overview;
                        if (is_null($episodeResume)) {
                            $logMessage = 'Pas de résumé de l\'épisode';
                            saveLogMessage($jobName, $logMessage);
                            $episodeResume = 'TBA';
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
                    $logMessage = 'Laison de l\'épisode';
                    saveLogMessage($jobName, $logMessage);
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
                            $logMessage = 'Création du guest ' . $guestStar . '.';
                            saveLogMessage($jobName, $logMessage);
                            # On prépare le nouveau guest
                            $guestStar_ref = new Artist([
                                'name' => $guestStar,
                                'artist_url' => $guestStar_url
                            ]);

                            # Et on le sauvegarde ne passant par l'objet Episode pour créer le lien entre les deux
                            $episode_ref->artists()->save($guestStar_ref, ['profession' => 'guest']);

                        } else {
                            $logMessage = 'Liaison du guest ' . $guestStar . '.';
                            saveLogMessage($jobName, $logMessage);
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
                            $logMessage = 'Création du réalisateur ' . $director . '.';
                            saveLogMessage($jobName, $logMessage);
                            # On prépare le nouveau réal
                            $director_ref = new Artist([
                                'name' => $director,
                                'artist_url' => $director_url
                            ]);

                            # Et on le sauvegarde ne passant par l'objet Episode pour créer le lien entre les deux
                            $episode_ref->artists()->save($director_ref, ['profession' => 'director']);

                        } else {
                            $logMessage = 'Liaison du réalisateur ' . $director . '.';
                            saveLogMessage($jobName, $logMessage);
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
                            $logMessage = 'Création du scénariste ' . $writer . '.';
                            saveLogMessage($jobName, $logMessage);
                            # On prépare le nouveau scénariste
                            $writer_ref = new Artist([
                                'name' => $writer,
                                'artist_url' => $writer_url
                            ]);

                            # Et on le sauvegarde ne passant par l'objet Episode pour créer le lien entre les deux
                            $episode_ref->artists()->save($writer_ref, ['profession' => 'writer']);

                        } else {
                            $logMessage = 'Liaison du scénariste ' . $writer . '.';
                            saveLogMessage($jobName, $logMessage);
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
        $theTVDBID = $this->inputs['thetvdb_id'];
        $userID = $this->inputs['user_id'];
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
        else{
            # Sinon, on utilise celui en base
            $token = $keyToken->value;
        }

        # Définition du nom du job
        $jobName = 'AddShow-' . $theTVDBID . '-BY-' . $userID;
        $logMessage = '>>>>>>>>>> Lancement du job d\'ajout <<<<<<<<<<';
        saveLogMessage($jobName, $logMessage);

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

        # Si la série et le synopsis ne sont pas rensignés en français, on met la version anglaise uniquement
        if(!is_null($show_fr->seriesName)) {
            $logMessage = 'Ajout du nom FR';
            saveLogMessage($jobName, $logMessage);
            $show_new->name_fr = $show_fr->seriesName;
        }
        else{
            $logMessage = 'Pas de nom FR';
            saveLogMessage($jobName, $logMessage);
            $show_new->name_fr = 'TBA';
        }
        if(!is_null($show_fr->overview)) {
            $logMessage = 'Ajout du résumé FR';
            saveLogMessage($jobName, $logMessage);
            $show_new->synopsis = $show_fr->overview;
        }
        else {
            if(!is_null($show_en->overview)) {
                $logMessage = 'Ajout du résumé EN';
                saveLogMessage($jobName, $logMessage);
                $show_new->synopsis = $show_en->overview;
            }
            else{
                $logMessage = 'Pas de résumé';
                saveLogMessage($jobName, $logMessage);
                $show_new->synopsis = 'TBA';
            }
        }

        if(!is_null($show_en->firstAired)) {
            $logMessage = 'Ajout de la date de diffusion US';
            saveLogMessage($jobName, $logMessage);
            $show_new->diffusion_us = $show_en->firstAired;        # Date de diffusion US
        }
        else{
            $logMessage = 'Pas de diffusion US';
            saveLogMessage($jobName, $logMessage);
            $show_new->diffusion_us = '1800-01-01';
        }

        $logMessage = 'Ajout de l\'ID TheTVDB, du nom original, du format, de la diffusion_fr, du taux érectile et de l\'avis de la rentrée.';
        saveLogMessage($jobName, $logMessage);
        $show_new->thetvdb_id = $theTVDBID;                         # L'ID de TheTVDB
        $show_new->name = $show_en->seriesName;                     # Le nom de la série
        $show_new->format = $show_en->runtime;                      # Le format de la série
        $show_new->diffusion_fr = $this->inputs['diffusion_fr'];    # Date de diffusion FR
        $show_new->taux_erectile = $this->inputs['taux_erectile'];  # Le taux érectile
        $show_new->avis_rentree = $this->inputs['avis_rentree'];    # Le taux érectile


        # Le champ en cours doit être à 1 si la série est en cours et à 0 dans le cas contraire
        if ($show_en->status == 'Continuing'){
            $logMessage = 'Série marquée en cours.';
            saveLogMessage($jobName, $logMessage);
            $show_new->encours = 1;
        }
        else
        {
            $logMessage = 'Série marquée terminée.';
            saveLogMessage($jobName, $logMessage);
            $show_new->encours = 0;
        }

        # Pour l'année, on va parser le champ firstAired et récupérer uniquement l'année
        $logMessage = 'Ajout de l\'année';
        saveLogMessage($jobName, $logMessage);
        $dateTemp = date_create($show_en->firstAired);     # On transforme d'abord le texte récupéré par la requête en date
        $show_new->annee = date_format($dateTemp, "Y");         # Ensuite on récupère l'année

        # Utilisation de la méthode Slug pour l'URL
        $logMessage = 'On transforme le nom pour l\'URL.';
        saveLogMessage($jobName, $logMessage);
        $show_new->show_url = Str::slug($show_new->name);

        $show_new->save();


        /*
        |--------------------------------------------------------------------------
        | Gestion des genres
        |--------------------------------------------------------------------------
        | On commence par récupérer les genres de The TVDB
        | Puis on les ajoute si ils n'existe pas dans la base
        | S'il existe on crée juste le lien avec la série
        */

        $genres = $show_en->genre;

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
                    $logMessage = 'Ajout du genre ' . $genre . '.';
                    saveLogMessage($jobName, $logMessage);
                    # On prépare le nouveau genre
                    $genre_ref = new Genre([
                        'name' => $genre,
                        'genre_url' => $genre_url
                    ]);

                    # Et on le sauvegarde ne passant par l'objet Show pour créer le lien entre les deux
                    $show_new->genres()->save($genre_ref);

                } else {
                    $logMessage = 'Liaison du genre ' . $genre . '.';
                    saveLogMessage($jobName, $logMessage);
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
                    $logMessage = 'Ajout du créateur ' . $creator . '.';
                    saveLogMessage($jobName, $logMessage);
                    # On prépare le nouveau créateur
                    $creator_ref = new Artist([
                        'name' => $creator,
                        'artist_url' => $creator_url
                    ]);

                    # Et on le sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $show_new->artists()->save($creator_ref, ['profession' => 'creator']);
                } else {
                    $logMessage = 'Liaison du créateur ' . $creator . '.';
                    saveLogMessage($jobName, $logMessage);
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
                    $logMessage = 'Ajout de la nationalité ' . $nationality . '.';
                    saveLogMessage($jobName, $logMessage);
                    # On prépare la nouvelle nationalité
                    $nationality_ref = new Nationality([
                        'name' => $nationality,
                        'nationality_url' => $nationality_url
                    ]);

                    # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $show_new->nationalities()->save($nationality_ref);
                } else {
                    $logMessage = 'Liaison de la nationalité ' . $nationality . '.';
                    saveLogMessage($jobName, $logMessage);
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
                    $logMessage = 'Ajout de la chaine ' . $channel . '.';
                    saveLogMessage($jobName, $logMessage);
                    # On prépare la nouvelle nationalité
                    $channel_ref = new Channel([
                        'name' => $channel,
                        'channel_url' => $channel_url
                    ]);

                    # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $show_new->channels()->save($channel_ref);
                } else {
                    $logMessage = 'Liaison de la chaine ' . $channel . '.';
                    saveLogMessage($jobName, $logMessage);
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
            foreach ($actors as $actor) {
                # Récupération du nom de l'acteur
                $actorName = $actor->name;

                # Récupération du rôle
                $actorRole = $actor->role;
                if (is_null($actorRole)) {
                    $logMessage = 'Rôle de ' . $actorName . ' non renseigné ' . $channel . '.';
                    saveLogMessage($jobName, $logMessage);
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
                    $logMessage = 'Création de l\'acteur ' . $actorName . '.';
                    saveLogMessage($jobName, $logMessage);
                    # On prépare la nouvelle saison
                    $actor_ref = new Artist([
                        'name' => $actor,
                        'artist_url' => $actor_url
                    ]);

                    # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $show_new->artists()->save($actor_ref, ['profession' => 'actor', 'role' => $actorRole]);
                } else {
                    $logMessage = 'Liaison de l\'acteur ' . $actorName . '.';
                    saveLogMessage($jobName, $logMessage);
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
            $this->AddEpisodeOneByOne($client, $getEpisodes, $api_version, $token, $show_new, $jobName);
        }
        else{
            $logMessage = 'En cours, page n°1';
            saveLogMessage($jobName, $logMessage);

            $this->AddEpisodeOneByOne($client, $getEpisodes, $api_version, $token, $show_new, $jobName);

            while($getEpisodeNextPage <= $getEpisodeLastPage) {
                $logMessage = 'En cours, page n°'.$getEpisodeNextPage;
                saveLogMessage($jobName, $logMessage);

                $getEpisodes_en = $client->request('GET', '/series/' . $theTVDBID .'/episodes?page='. $getEpisodeNextPage, [
                    'headers' => [
                        'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                        'Authorization' => 'Bearer ' . $token,
                        'Accept-Language' => 'en',
                    ]
                ])->getBody();

                $getEpisodes_en = json_decode($getEpisodes_en);
                $getEpisodes = $getEpisodes_en->data;

                $this->AddEpisodeOneByOne($client, $getEpisodes, $api_version, $token, $show_new, $jobName);
                $getEpisodeNextPage++;
            }
        }
        $logMessage = '>>>>>>>>>> Lancement du job d\'ajout <<<<<<<<<<';
        saveLogMessage($jobName, $logMessage);
    }
}
