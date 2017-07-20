<?php

namespace App\Jobs;

use App\Models\Episode;
use App\Models\Artist;

use App\Repositories\SeasonRepository;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class EpisodeStore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * Execute the job.
     *
     * @param SeasonRepository $seasonRepository
     * @return void
     */
    public function handle(SeasonRepository $seasonRepository)
    {
        $idLog = initJob($this->inputs['user_id'], 'Ajout Manuel', 'Episode', mt_rand());
        $season = $seasonRepository->getSeasonByID($this->inputs['season_id']);

        foreach($this->inputs['episodes'] as $episode) {
            $episodeNew = new Episode();
            $logMessage = '>EPISODE';
            saveLogMessage($idLog, $logMessage);

            $episodeNew->numero = $episode['numero'];
            # Numéro de l'épisode
            $logMessage = '>>Numéro : ' . $episodeNew->numero;
            saveLogMessage($idLog, $logMessage);

            $episodeNew->name = $episode['name'];
            # Nom FR de l'épisode
            $logMessage = '>>Nom FR : ' . $episodeNew->name;
            saveLogMessage($idLog, $logMessage);

            $episodeNew->name_fr = $episode['name_fr'];
            # Nom FR de l'épisode
            $logMessage = '>>Nom FR : ' . $episodeNew->name_fr;
            saveLogMessage($idLog, $logMessage);

            $episodeNew->resume = $episode['resume'];
            # Résumé EN de l'épisode
            $logMessage = '>>Résumé FR : ' . $episodeNew->resume;
            saveLogMessage($idLog, $logMessage);

            $episodeNew->resume_fr = $episode['resume_fr'];
            # Résumé FR de la série
            $logMessage = '>>Résumé FR : ' . $episodeNew->resume_fr;
            saveLogMessage($idLog, $logMessage);

            $episodeNew->diffusion_fr = $episode['diffusion_fr'];
            # Diffusion FR de l'épisode
            $logMessage = '>>Diffusion FR : ' . $episodeNew->diffusion_fr;
            saveLogMessage($idLog, $logMessage);

            $episodeNew->diffusion_us = $episode['diffusion_us'];
            # Diffusion US de l'épisode
            $logMessage = '>>Diffusion US : ' . $episodeNew->diffusion_us;
            saveLogMessage($idLog, $logMessage);

            $episodeNew->ba = $episode['ba'];
            # Bande Annonce de l'épisode
            $message = 'Bande Annonce : ' . $episode['ba'];
            saveLogMessage($idLog, $message);

            $episodeNew->season()->associate($season);
            $episodeNew->save();

            /*
        |--------------------------------------------------------------------------
        | Récupérations des informations sur les directors
        |--------------------------------------------------------------------------
        */
            $directors = $episode['directors'];
            $listDirectors = null;

            if (!empty($directors)) {
                $logMessage = '>>REALISATEURS';
                saveLogMessage($idLog, $logMessage);
                $directors = explode(',', $directors);

                # Pour chaque réalisateur
                foreach ($directors as $director) {
                    # On supprime les espaces
                    $director = trim($director);
                    # On met en forme l'URL
                    $director_url = Str::slug($director);
                    # On vérifie si le réalisateur existe déjà en base
                    $director_ref = Artist::where('artist_url', $director_url)->first();

                    # Si il n'existe pas
                    if (is_null($director_ref)) {
                        $logMessage = '>>>Ajout du réalisateur : ' . $director . '.';
                        saveLogMessage($idLog, $logMessage);
                        # On prépare le nouveau réalisateur
                        $director_ref = new Artist([
                            'name' => $director,
                            'artist_url' => $director_url
                        ]);

                        # Et on le sauvegarde en passant par l'objet Episode pour créer le lien entre les deux
                        $director_ref->save();
                    }
                    $listDirectors[] = $director_ref->id;
                }

                $pivotData = array_fill(0, count($listDirectors), ['profession' => 'director']);
                $syncData  = array_combine($listDirectors, $pivotData);

                $episodeNew->directors()->sync($syncData);
            }
            else
            {
                $episodeNew->directors()->sync([]);
            }

            $logMessage = '>>>Synchronisation des réalisateurs.';
            saveLogMessage($idLog, $logMessage);

            /*
            |--------------------------------------------------------------------------
            | Récupérations des informations sur les scénaristes
            |--------------------------------------------------------------------------
            */
            $writers = $episode['writers'];
            $listWriters = null;

            if (!empty($writers)) {
                $logMessage = '>>SCENARISTES';
                saveLogMessage($idLog, $logMessage);
                $writers = explode(',', $writers);

                # Pour chaque scénariste
                foreach ($writers as $writer) {
                    # On supprime les espaces
                    $writer = trim($writer);
                    # On met en forme l'URL
                    $writer_url = Str::slug($writer);
                    # On vérifie si le genre existe déjà en base
                    $writer_ref = Artist::where('artist_url', $writer_url)->first();

                    # Si il n'existe pas
                    if (is_null($writer_ref)) {
                        $logMessage = '>>>Ajout du scénariste : ' . $writer . '.';
                        saveLogMessage($idLog, $logMessage);
                        # On prépare le nouveau scénariste
                        $writer_ref = new Artist([
                            'name' => $writer,
                            'artist_url' => $writer_url
                        ]);

                        # Et on le sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                        $writer_ref->save();
                    }
                    $listWriters[] = $writer_ref->id;
                }
                $pivotData = array_fill(0, count($listWriters), ['profession' => 'writer']);
                $syncData  = array_combine($listWriters, $pivotData);

                $episodeNew->writers()->sync($syncData);
            }
            else
            {
                $episodeNew->writers()->sync([]);
            }

            $logMessage = '>>>Synchronisation des scénaristes.';
            saveLogMessage($idLog, $logMessage);

            /*
            |--------------------------------------------------------------------------
            | Récupérations des informations sur les guests
            |--------------------------------------------------------------------------
            */
            $guests = $episode['guests'];
            $listGuests = null;

            if (!empty($guests)) {
                $logMessage = '>>GUESTS';
                saveLogMessage($idLog, $logMessage);
                $guests = explode(',', $guests);

                # Pour chaque guest
                foreach ($guests as $guest) {
                    # On supprime les espaces
                    $guest = trim($guest);
                    # On met en forme l'URL
                    $guest_url = Str::slug($guest);
                    # On vérifie si le genre existe déjà en base
                    $guest_ref = Artist::where('artist_url', $guest_url)->first();

                    # Si il n'existe pas
                    if (is_null($guest_ref)) {
                        $logMessage = '>>>Ajout du guest : ' . $guest . '.';
                        saveLogMessage($idLog, $logMessage);
                        # On prépare le nouveau guest
                        $guest_ref = new Artist([
                            'name' => $guest,
                            'artist_url' => $guest_url
                        ]);

                        # Et on le sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                        $guest_ref->save();
                    }
                    $listGuests[] = $guest_ref->id;
                }
                $pivotData = array_fill(0, count($listGuests), ['profession' => 'guest']);
                $syncData  = array_combine($listGuests, $pivotData);

                $episodeNew->guests()->sync($syncData);
            }
            else
            {
                $episodeNew->guests()->sync([]);
            }

            $logMessage = '>>>Synchronisation des guests.';
            saveLogMessage($idLog, $logMessage);
        }

        endJob($idLog);
    }
}
