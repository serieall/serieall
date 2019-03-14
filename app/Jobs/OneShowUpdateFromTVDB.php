<?php

namespace App\Jobs;

use App\Models\Show;
use App\Models\Artist;
use App\Models\Temp;
use App\Models\Season;
use App\Models\Episode;

use App\Repositories\ShowRepository;
use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use GuzzleHttp\Client;

use \Illuminate\Support\Str;

/**
 * Class ShowUpdateFromTVDB
 * @package App\Jobs
 */
class OneShowUpdateFromTVDB extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $id;
    protected $showRepository;

    /**
     * ShowUpdateFromTVDB constructor.
     * @param $id
     * @param ShowRepository $showRepository
     */
    public function __construct($id, $showRepository)
    {
        $this->id = $id;
        $this->showRepository = $showRepository;
    }

    /**
     * @param $getEpisode_en
     * @param $idLog
     * @param $episodeID
     */
    private function UpdateWritersDirectorsGuests($getEpisode_en, $idLog, $episodeID){
        $episode_ref = Episode::where('thetvdb_id', $episodeID)->first();

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
                    $logMessage = '>>>>>>Création du scénariste : ' . $writer;
                    saveLogMessage($idLog, $logMessage);

                    # On prépare le nouveau scénariste
                    $writer_ref = new Artist([
                        'name' => $writer,
                        'artist_url' => $writer_url
                    ]);

                    # Et on le sauvegarde ne passant par l'objet Episode pour créer le lien entre les deux
                    $episode_ref->artists()->save($writer_ref, ['profession' => 'writer']);

                } else {
                    # On vérifie que le scénariste n'est pas déjà lié à la série
                    $writer_liaison = $writer_ref->episodes()
                        ->where('episodes.thetvdb_id', $episodeID)
                        ->where('artistables.profession', 'writer')
                        ->first();

                    if (is_null($writer_liaison)) {
                        # On lie l'acteur à la série
                        $logMessage = '>>>>>>Liaison du scénariste : ' . $writer;
                        saveLogMessage($idLog, $logMessage);

                        $episode_ref->artists()->attach($writer_ref->id, ['profession' => 'writer']);
                    }
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
                    $logMessage = '>>>>>>Création du réalisateur : ' . $director;
                    saveLogMessage($idLog, $logMessage);

                    # On prépare le nouveau réal
                    $director_ref = new Artist([
                        'name' => $director,
                        'artist_url' => $director_url
                    ]);

                    # Et on le sauvegarde ne passant par l'objet Episode pour créer le lien entre les deux
                    $episode_ref->artists()->save($director_ref, ['profession' => 'director']);

                } else {
                    # On vérifie que le scénariste n'est pas déjà lié à la série
                    $director_liaison = $director_ref->episodes()
                        ->where('episodes.thetvdb_id', $episodeID)
                        ->where('artistables.profession', 'director')
                        ->first();

                    if (is_null($director_liaison)) {
                        # On lie l'acteur à la série
                        $logMessage = '>>>>>>Liaison du réalisateur : ';
                        saveLogMessage($idLog, $logMessage);

                        $episode_ref->artists()->attach($director_ref->id, ['profession' => 'director']);
                    }
                }
            }
        }

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
                    $logMessage = '>>>>>>Création du guest : ' . $guestStar;
                    saveLogMessage($idLog, $logMessage);

                    # On prépare le nouveau guest
                    $guestStar_ref = new Artist([
                        'name' => $guestStar,
                        'artist_url' => $guestStar_url
                    ]);

                    # Et on le sauvegarde ne passant par l'objet Episode pour créer le lien entre les deux
                    $episode_ref->artists()->save($guestStar_ref, ['profession' => 'guest']);

                } else {
                    # On vérifie que le scénariste n'est pas déjà lié à la série
                    $guest_liaison = $guestStar_ref->episodes()
                        ->where('episodes.thetvdb_id', $episodeID)
                        ->where('artistables.profession', 'guest')
                        ->first();

                    if (is_null($guest_liaison)) {
                        # On lie l'acteur à la série
                        $logMessage = '>>>>>>Liaison du guest : ' . $guestStar;
                        saveLogMessage($idLog, $logMessage);

                        $episode_ref->artists()->attach($guestStar_ref->id, ['profession' => 'guest']);
                    }
                }
            }
        }
    }

    /**
     * @param $getEpisodes
     * @param $api_version
     * @param $token
     * @param $show
     * @param $idLog
     *
     * @param $api_url
     * @return void
     * @internal param $client
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function UpdateEpisodeOneByOne($getEpisodes, $api_version, $token, $show, $idLog, $api_url)
    {
        $client = new Client(['base_uri' => $api_url]);

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
                    'Accept-Language' => 'fr']
                ])->getBody();

            $getEpisode_en = $client->request('GET', '/episodes/' . $episodeID, [
                'headers' => [
                    'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                    'Authorization' => 'Bearer ' . $token,
                    'Accept-Language' => 'en']
            ])->getBody();

            # On décode le JSON
            $getEpisode_fr = json_decode($getEpisode_fr);
            $getEpisode_en = json_decode($getEpisode_en);

            $getEpisode_en = $getEpisode_en->data;
            $getEpisode_fr = $getEpisode_fr->data;

            # Si l'épisode a été mis à jour depuis la dernière fois
            $lastUpdate = Temp::where('key', 'last_update')->first();
            $lastUpdate = $lastUpdate->value;

            $episode_ref = Episode::where('thetvdb_id', $episodeID)->first();

            if ($lastUpdate <= $getEpisode_en->lastUpdated || is_null($episode_ref)) {
                if ($seasonNumber != 0) {
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
                        $season_ref->show()->associate($show);
                        $season_ref->save();
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Récupération des informations de l'épisode
                    |--------------------------------------------------------------------------
                    | On crée l'épisode s'il n'existe pas
                    */

                    # Vérification de la présence de l'épisode dans la BDD
                    $episode_ref = Episode::where('thetvdb_id', $episodeID)->first();

                    # Si il n'existe pas
                    if (is_null($episode_ref)) {

                        $episodeNumero = $getEpisode_en->airedEpisodeNumber;
                        $logMessage = '>>>>NEW EPISODE ' . $seasonName . '.' . $episodeNumero;
                        saveLogMessage($idLog, $logMessage);

                        # TheTVDB ID
                        $logMessage = '>>>>>ID TheTVDB : ' . $episodeID;
                        saveLogMessage($idLog, $logMessage);

                        # Numéro
                        $logMessage = '>>>>>Numéro : ' . $episodeNumero;
                        saveLogMessage($idLog, $logMessage);

                        $episodeName = $getEpisode_en->episodeName;
                        # Nom original de l'épisode
                        $logMessage = '>>>>>Nom original de l\'épisode : ' . $episodeName;
                        saveLogMessage($idLog, $logMessage);

                        $episodeNameFR = $getEpisode_fr->episodeName;
                        # Nom français de l\'épisode
                        $logMessage = '>>>>>Nom français de l\'épisode : ' . $episodeNameFR;
                        saveLogMessage($idLog, $logMessage);

                        $episodeResumeEN = $getEpisode_en->overview;
                        # Résumé original
                        $logMessage = '>>>>>Résumé original : ' . $episodeResumeEN;
                        saveLogMessage($idLog, $logMessage);

                        $episodeResumeFR = $getEpisode_fr->overview;
                        # Résumé original
                        $logMessage = '>>>>>Résumé français : ' . $episodeResumeFR;
                        saveLogMessage($idLog, $logMessage);

                        $episodeDiffusionFR = $getEpisode_fr->firstAired;
                        # Diffusion française
                        $logMessage = '>>>>>Diffusion française : ' . $episodeDiffusionFR;
                        saveLogMessage($idLog, $logMessage);

                        $episodeDiffusionUS = $getEpisode_en->firstAired;
                        # Diffusion originale
                        $logMessage = '>>>>>Diffusion originale : ' . $episodeDiffusionUS;
                        saveLogMessage($idLog, $logMessage);

                        $episodePicture = 'https://www.thetvdb.com/banners/' . $getEpisode_en->filename;
                        # Image
                        $logMessage = '>>>>>Image : ' . $episodePicture;
                        saveLogMessage($idLog, $logMessage);

                        # On prépare le nouvel épisode
                        $episode_ref = new Episode([
                            'numero' => $episodeNumero,
                            'name' => $episodeName,
                            'name_fr' => $episodeNameFR,
                            'thetvdb_id' => $episodeID,
                            'resume' => $episodeResumeEN,
                            'resume_fr' => $episodeResumeFR,
                            'diffusion_us' => $episodeDiffusionUS,
                            'diffusion_fr' => $episodeDiffusionFR,
                            'picture' => $episodePicture]);
                        # Et on le sauvegarde en passant par l'objet Season pour créer le lien entre les deux
                        $episode_ref->season()->associate($season_ref);
                        $episode_ref->save();

                        # Mise à jour des artistes
                        $this->UpdateWritersDirectorsGuests($getEpisode_en, $idLog, $episodeID);
                    } else {
                        /*
                        |--------------------------------------------------------------------------
                        | On va chercher les modifications qui pourraient avoir eu lieu
                        | et qui nous intéresse.
                        |--------------------------------------------------------------------------
                        */

                        $logMessage = '>>>>MAJ EPISODE ' . $seasonName . '.' . $episode_ref->numero;
                        saveLogMessage($idLog, $logMessage);

                        $nomENEpisode = $episode_ref->name;
                        # Si le nom FR est à TBA dans notre base
                        if (is_null($nomENEpisode) && !is_null($getEpisode_en->episodeName)) {
                            $episode_ref->name = $getEpisode_en->episodeName;
                            # Nom original
                            $logMessage = '>>>>>Nom original : ' . $episode_ref->name;
                            saveLogMessage($idLog, $logMessage);
                        }

                        $nomFREpisode = $episode_ref->name_fr;
                        # Si le nom FR est à TBA dans notre base
                        if (is_null($nomFREpisode) && !is_null($getEpisode_fr->episodeName)) {
                            $episode_ref->name_fr = $getEpisode_fr->episodeName;
                            # On sauvegarde le nom en français
                            $logMessage = '>>>>>Nom français : ' . $episode_ref->name_fr;
                            saveLogMessage($idLog, $logMessage);
                        }

                        $resumeEpisodeEN = $episode_ref->resume;
                        # Si le résumé est à TBA dans notre base
                        if (is_null($resumeEpisodeEN) && !is_null($getEpisode_fr->overview)) {
                            # On sauvegarde le résumé en EN
                            $episode_ref->resume = $getEpisode_en->overview;
                            $logMessage = '>>>>>Résumé original : ' . $episode_ref->resume;
                            saveLogMessage($idLog, $logMessage);
                        }

                        $resumeEpisodeFR = $episode_ref->resume_fr;
                        # Si le résumé est à TBA dans notre base
                        if (is_null($resumeEpisodeFR) && !is_null($getEpisode_fr->overview)) {
                            $episode_ref->resume_fr = $getEpisode_fr->overview;
                            # On sauvegarde le résumé en français
                            $logMessage = '>>>>>Résumé Français : ' . $episode_ref->resume_fr;
                            saveLogMessage($idLog, $logMessage);
                        }

                        $diffusionEpisode = $episode_ref->diffusion_us;
                        # Si la diffusion est renseignée sur theTVDB
                        if (!empty($getEpisode_en->firstAired)) {
                            # Si la diffusion dans notre BDD est différente de celle dans TheTVDB
                            if ($diffusionEpisode != $getEpisode_en->firstAired) {
                                $episode_ref->diffusion_us = $getEpisode_en->firstAired;
                                # On enregistre la nouvelle diffusion
                                $logMessage = '>>>>>Diffusion US : ' . $episode_ref->diffusion_us;
                                saveLogMessage($idLog, $logMessage);
                            }
                        }

                        # On sauvegarde les modifs
                        $episode_ref->save();

                        # Mise à jour des artistes
                        $this->UpdateWritersDirectorsGuests($getEpisode_en, $idLog, $episodeID);
                    }
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

                    if(!is_null($getEpisode_en->airsAfterSeason)) {
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
                            ->where('show_id', $show->id)
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
                            $season_ref->show()->associate($show);
                            $season_ref->save();
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Récupération des informations de l'épisode
                        |--------------------------------------------------------------------------
                        | On crée l'épisode s'il n'existe pas
                        */

                        # Vérification de la présence de l'épisode dans la BDD
                        $episode_ref = Episode::where('thetvdb_id', $episodeID)->first();

                        # Si il n'existe pas
                        if (is_null($episode_ref)) {

                            $episodeNumero = 0; # 0 Désigne un épisode spécial
                            $logMessage = '>>>>NEW EPISODE ' . $seasonName . '.' . $episodeNumero;
                            saveLogMessage($idLog, $logMessage);

                            # TheTVDB ID
                            $logMessage = '>>>>>ID TheTVDB : ' . $episodeID;
                            saveLogMessage($idLog, $logMessage);

                            # Numéro
                            $logMessage = '>>>>>Numéro : ' . $episodeNumero;
                            saveLogMessage($idLog, $logMessage);

                            $episodeName = $getEpisode_en->episodeName;
                            # Nom original de l'épisode
                            $logMessage = '>>>>>Nom original de l\'épisode : ' . $episodeName;
                            saveLogMessage($idLog, $logMessage);

                            $episodeNameFR = $getEpisode_fr->episodeName;
                            # Nom français de l\'épisode
                            $logMessage = '>>>>>Nom français de l\'épisode : ' . $episodeNameFR;
                            saveLogMessage($idLog, $logMessage);

                            $episodeResumeEN = $getEpisode_en->overview;
                            # Résumé original
                            $logMessage = '>>>>>Résumé original : ' . $episodeResumeEN;
                            saveLogMessage($idLog, $logMessage);

                            $episodeResumeFR = $getEpisode_fr->overview;
                            # Résumé original
                            $logMessage = '>>>>>Résumé français : ' . $episodeResumeFR;
                            saveLogMessage($idLog, $logMessage);

                            $episodeDiffusionUS = $getEpisode_en->firstAired;
                            # Diffusion originale
                            $logMessage = '>>>>>Diffusion originale : ' . $episodeDiffusionUS;
                            saveLogMessage($idLog, $logMessage);

                            /* Récupération de la photo de l'épisode */
                            if(empty($getEpisode_en->filenam)) {
                                $episodePicture = null;

                                $logMessage = '>>>Pas d\'image pour l\'épisode.';
                                saveLogMessage($idLog, $logMessage);
                            }
                            else {
                                $file = 'https://www.thetvdb.com/banners/' . $getEpisode_en->filename;
                                $file_headers = get_headers($file);
                                if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                                    $episodePicture = null;

                                    $logMessage = '>>>Pas d\'image pour l\'épisode.';
                                    saveLogMessage($idLog, $logMessage);
                                } else {
                                    $episodePicture = 'https://www.thetvdb.com/banners/' . $getEpisode_en->filename;
                                    # Image
                                    $logMessage = '>>>>>Image : ' . $episodePicture;
                                    saveLogMessage($idLog, $logMessage);
                                }
                            }

                            # On prépare le nouvel épisode
                            $episode_ref = new Episode([
                                'numero' => $episodeNumero,
                                'name' => $episodeName,
                                'name_fr' => $episodeNameFR,
                                'thetvdb_id' => $episodeID,
                                'resume' => $episodeResumeEN,
                                'resume_fr' => $episodeResumeFR,
                                'diffusion_us' => $episodeDiffusionUS,
                                'picture' => $episodePicture]);

                            # Et on le sauvegarde en passant par l'objet Season pour créer le lien entre les deux
                            $episode_ref->season()->associate($season_ref);
                            $episode_ref->save();

                            # Mise à jour des artistes
                            $this->UpdateWritersDirectorsGuests($getEpisode_en, $idLog, $episodeID);
                        } else {
                            /*
                            |--------------------------------------------------------------------------
                            | On va chercher les modifications qui pourraient avoir eu lieu
                            | et qui nous intéresse.
                            |--------------------------------------------------------------------------
                            */

                            $logMessage = '>>>>MAJ EPISODE ' . $seasonName . '.' . $episode_ref->numero;
                            saveLogMessage($idLog, $logMessage);

                            $nomENEpisode = $episode_ref->name;
                            # Si le nom FR est à TBA dans notre base
                            if (is_null($nomENEpisode) && !is_null($getEpisode_en->episodeName)) {
                                $episode_ref->name = $getEpisode_en->episodeName;
                                # Nom original
                                $logMessage = '>>>>>Nom original : ' . $episode_ref->name;
                                saveLogMessage($idLog, $logMessage);
                            }

                            $nomFREpisode = $episode_ref->name_fr;
                            # Si le nom FR est à TBA dans notre base
                            if (is_null($nomFREpisode) && !is_null($getEpisode_fr->episodeName)) {
                                $episode_ref->name_fr = $getEpisode_fr->episodeName;
                                # On sauvegarde le nom en français
                                $logMessage = '>>>>>Nom français : ' . $episode_ref->name_fr;
                                saveLogMessage($idLog, $logMessage);
                            }

                            $resumeEpisodeEN = $episode_ref->resume;
                            # Si le résumé est à TBA dans notre base
                            if (is_null($resumeEpisodeEN) && !is_null($getEpisode_fr->overview)) {
                                # On sauvegarde le résumé en EN
                                $episode_ref->resume = $getEpisode_en->overview;
                                $logMessage = '>>>>>Résumé original : ' . $episode_ref->resume;
                                saveLogMessage($idLog, $logMessage);
                            }

                            $resumeEpisodeFR = $episode_ref->resume_fr;
                            # Si le résumé est à TBA dans notre base
                            if (is_null($resumeEpisodeFR) && !is_null($getEpisode_fr->overview)) {
                                $episode_ref->resume_fr = $getEpisode_fr->overview;
                                # On sauvegarde le résumé en français
                                $logMessage = '>>>>>Résumé Français : ' . $episode_ref->resume_fr;
                                saveLogMessage($idLog, $logMessage);
                            }

                            $diffusionEpisode = $episode_ref->diffusion_us;
                            # Si la diffusion est renseignée sur theTVDB
                            if (!empty($getEpisode_en->firstAired)) {
                                # Si la diffusion dans notre BDD est différente de celle dans TheTVDB
                                if ($diffusionEpisode != $getEpisode_en->firstAired) {
                                    $episode_ref->diffusion_us = $getEpisode_en->firstAired;
                                    # On enregistre la nouvelle diffusion
                                    $logMessage = '>>>>>Diffusion US : ' . $episode_ref->diffusion_us;
                                    saveLogMessage($idLog, $logMessage);
                                }
                            }

                            /* Récupération de la photo de l'épisode */
                            if(!empty($getEpisode_en->filenam)) {
                                $file = 'https://www.thetvdb.com/banners/' . $getEpisode_en->filename;
                                $file_headers = get_headers($file);
                                if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                                    $logMessage = '>>>Pas d\'image pour l\'épisode.';
                                    saveLogMessage($idLog, $logMessage);
                                } else {
                                    $episodePicture = 'https://www.thetvdb.com/banners/' . $getEpisode_en->filename;
                                    $episode_ref->picture = $episodePicture;

                                    # Image
                                    $logMessage = '>>>>>Image : ' . $episodePicture;
                                    saveLogMessage($idLog, $logMessage);
                                }
                            }

                            # On sauvegarde les modifs
                            $episode_ref->save();

                            # Mise à jour des artistes
                            $this->UpdateWritersDirectorsGuests($getEpisode_en, $idLog, $episodeID);
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        /*
        |--------------------------------------------------------------------------
        | Initialisation du job
        |--------------------------------------------------------------------------
        */
        $idLog = initJob(null, 'Mise à jour via TVDB', 'Show', $this->id );

        /*
        |--------------------------------------------------------------------------
        | Définition des variables
        |--------------------------------------------------------------------------
        */
        $show_id = $this->id;
        $show = $this->showRepository->getShowByID($show_id);
        $key_token = 'token';
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
        if ($resetToken > $hours_duration_token) {
            #On récupère un nouveau token et on l'enregistre en base
            $getToken = $client->request('POST', '/login', [
                'header' => [
                    'Accept' => 'application/vnd.thetvdb.v' . $api_version],
                'json' => [
                    'apikey' => $api_key,
                    'username' => $api_username,
                    'userkey' => $api_userkey]
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
        | Recupération de la série en français et avec la langue par défaut
        |--------------------------------------------------------------------------
        | Le paramètre passé est l'ID de TheTVDB passé dans le formulaire
        | On précise la version de l'API a utiliser, que l'on veut recevoir du JSON.
        | On passe également en paramètre le token.
        */

        $getShow_fr = $client->request('GET', '/series/' . $show->thetvdb_id, [
            'headers' => [
                'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                'Authorization' => 'Bearer ' . $token,
                'Accept-Language' => 'fr']
        ])->getBody();

        $getShow_en = $client->request('GET', '/series/' . $show->thetvdb_id, [
            'headers' => [
                'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                'Authorization' => 'Bearer ' . $token,
                'Accept-Language' => 'en']
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

        $logMessage = '>> Nom original : ' . $show_en->seriesName;
        saveLogMessage($idLog, $logMessage);

        $nomFRSerie = $show->name_fr;
        # Si le nom FR est à TBA dans notre base
        if (is_null($nomFRSerie) && !is_null($show_fr->seriesName)) {
            $show->name_fr = $show_fr->seriesName;
            # On sauvegarde le nom en français
            $logMessage = '>> Nom français : ' . $show->name_fr;
            saveLogMessage($idLog, $logMessage);
        }

        $resumeSerieEN = $show->synopsis;
        # Si le résumé est à TBA dans notre base
        if (is_null($resumeSerieEN) && !is_null($show_en->overview)) {
            $show->synopsis = $show_en->overview;
            # On sauvegarde le résumé en anglais
            $logMessage = '>> Résumé original : ' . $show->synopsis;
            saveLogMessage($idLog, $logMessage);
        }

        $resumeSerieFR = $show->synopsis_fr;
        # Si le résumé est à TBA dans notre base
        if (is_null($resumeSerieFR) && !is_null($show_fr->overview)) {
            $show->synopsis_fr = $show_fr->overview;
            # On sauvegarde le résumé en français
            $logMessage = '>> Résumé français : ' . $show->synopsis_fr;
            saveLogMessage($idLog, $logMessage);
        }

        $statutSerie = $show->encours;
        # Si le statut est à 1 dans notre base
        if ($statutSerie == '1') {
            # On vérifie le statut sur TheTVDB
            if ($show_en->status == 'Ended') {
                $show->encours = 0;
                # On enregistre le nouveau statut
                $logMessage = '>> En cours : ' . $show->encours;
                saveLogMessage($idLog, $logMessage);
            }
        }

        $diffusionSerie = $show->diffusion_us;
        # Si la diffusion est renseignée sur theTVDB
        if (!empty($show_en->firstAired)) {
            # Si la diffusion dans notre BDD est différente de celle dans TheTVDB
            if ($diffusionSerie != $show_en->firstAired) {
                $show->diffusion_us = $show_en->firstAired;
                # On enregistre la nouvelle diffusion
                $logMessage = '>> Diffusion US : ' . $show->diffusion_us;
                saveLogMessage($idLog, $logMessage);

                $dateTemp = date_create($show_en->firstAired);
                $show->annee = date_format($dateTemp, 'Y');
                # Année
                $logMessage = '>> Année : ' . $show->annee;
                saveLogMessage($idLog, $logMessage);
            }
        }

        $show->save();

        /*
        |--------------------------------------------------------------------------
        | Gestion des acteurs
        |--------------------------------------------------------------------------
        | On commence par récupérer les chaines du formulaire
        */
        /* Récupération de la photo de l'acteur */
        $file = 'https://www.thetvdb.com/banners/series/'. $show->thetvdb_id . '/actors';
        $file_headers = get_headers($file);
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $logMessage = '>>>Pas d\'acteurs pour la série.';
            saveLogMessage($idLog, $logMessage);
        }
        else {
            $getActors = $client->request('GET', '/series/' . $show->thetvdb_id . '/actors', [
                'headers' => [
                    'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                    'Authorization' => 'Bearer ' . $token]
            ])->getBody();

            /*
            |--------------------------------------------------------------------------
            | Décodage du JSON
            |--------------------------------------------------------------------------
            */
            $actors = json_decode($getActors);
            $actors = $actors->data;

            if (!is_null($actors)) {
                $logMessage = '>>ACTEURS';
                saveLogMessage($idLog, $logMessage);

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

                    if (is_null($actor_ref)) {
                        # On prépare le nouvel acteur
                        $actor_ref = new Artist([
                            'name' => $actor,
                            'artist_url' => $actor_url
                        ]);

                        # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                        $logMessage = '>>>Création de l\'acteur ' . $actorName . '.';
                        saveLogMessage($idLog, $logMessage);

                        $show->artists()->save($actor_ref, ['profession' => 'actor', 'role' => $actorRole]);

                        /* Récupération de la photo de l'acteur */
                        $file = 'https://www.thetvdb.com/banners/actors/' . $actor_ref->id . '.jpg';
                        $file_headers = get_headers($file);
                        if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                            $logMessage = '>>>Pas d\'image pour l\'acteur ' . $actorName . '.';
                            saveLogMessage($idLog, $logMessage);
                        } else {
                            copy($file, $public . '/images/actors/' . $actor_ref->artist_url . '.jpg');
                            $logMessage = '>>>Image pour l\'acteur ' . $actorName . ' récupérée.';
                            saveLogMessage($idLog, $logMessage);
                        }
                    } else {
                        # On vérifie s'il est déjà lié à la série

                        $actor_liaison = $actor_ref->shows()
                            ->where('shows.thetvdb_id', $show->thetvdb_id)
                            ->where('artistables.profession', 'actor')
                            ->get()
                            ->toArray();

                        if (empty($actor_liaison)) {
                            # On lie l'acteur à la série
                            $logMessage = '>>>Liaison de l\'acteur ' . $actorName . '.';
                            saveLogMessage($idLog, $logMessage);

                            $show->artists()->attach($actor_ref->id, ['profession' => 'actor', 'role' => $actorRole]);
                        } else {
                            # On vérifie que le rôle de l'acteur est à TBA
                            $actor_role = $actor_ref->shows()
                                ->where('shows.thetvdb_id', $show->thetvdb_id)
                                ->where('artistables.profession', 'actor')
                                ->where('artistables.role', 'TBA')
                                ->pluck('shows.id')
                                ->toArray();

                            if (!empty($actor_role)) {
                                # On vérifie que le rôle est rempli sur TheTVDB
                                if ($actorRole != 'TBA') {
                                    # On met à jour le rôle
                                    $logMessage = '>>>Mise à jour du rôle de l\'acteur : ' . $actor . '-' . $actorRole;
                                    saveLogMessage($idLog, $logMessage);

                                    $actor_ref->shows()->updateExistingPivot($actor_role[0], ['role' => $actorRole]);
                                }
                            }
                        }
                    }
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | On va chercher tous les épisodes
        |--------------------------------------------------------------------------
        */
        $getEpisodes_en = $client->request('GET', '/series/' . $show->thetvdb_id  .'/episodes?page=1', [
            'headers' => [
                'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                'Authorization' => 'Bearer ' . $token,
                'Accept-Language' => 'en']
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
            $this->UpdateEpisodeOneByOne($getEpisodes, $api_version, $token, $show, $idLog, $api_url);
        }
        else {
            $logMessage = 'En cours, page n°1';
            saveLogMessage($idLog, $logMessage);

            $this->UpdateEpisodeOneByOne($getEpisodes, $api_version, $token, $show, $idLog, $api_url);

            while ($getEpisodeNextPage <= $getEpisodeLastPage) {
                $logMessage = 'En cours, page n°' . $getEpisodeNextPage;
                saveLogMessage($idLog, $logMessage);

                $getEpisodes_en = $client->request('GET', '/series/' . $show->thetvdb_id . '/episodes?page=' . $getEpisodeNextPage, [
                    'headers' => [
                        'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                        'Authorization' => 'Bearer ' . $token,
                        'Accept-Language' => 'en']
                ])->getBody();

                $getEpisodes_en = json_decode($getEpisodes_en);
                $getEpisodes = $getEpisodes_en->data;

                $this->UpdateEpisodeOneByOne($getEpisodes, $api_version, $token, $show, $idLog, $api_url);
                $getEpisodeNextPage++;
            }
        }

        endJob($idLog);
    }
}