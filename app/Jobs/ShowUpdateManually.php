<?php

namespace App\Jobs;

use App\Models\Show;
use App\Models\Genre;
use App\Models\Channel;
use App\Models\Nationality;
use App\Models\Artist;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;


/**
 * Class ShowUpdateManually
 * @package App\Jobs
 */
class ShowUpdateManually implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

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
     * @return void
     */
    public function handle()
    {
        /*
        |--------------------------------------------------------------------------
        | Initialisation du job
        |--------------------------------------------------------------------------
        */

        $idLog = initJob($this->inputs['user_id'], 'Mise à jour manuelle', 'Show', mt_rand());

        /*
        |--------------------------------------------------------------------------
        | Ajout des informations sur la saison
        |--------------------------------------------------------------------------
        */

        $show = Show::where('id', '=', $this->inputs['id'])->first();

        $logMessage = '>SERIE';
        saveLogMessage($idLog, $logMessage);

        $show->name_fr = $this->inputs['name_fr'];
        # Nom FR de la série
        $logMessage = '>>Nom FR : ' . $show->name_fr;
        saveLogMessage($idLog, $logMessage);

        $show->synopsis_fr = $this->inputs['resume_fr'];
        # Résumé FR de la série
        $logMessage = '>>Résumé FR : ' . $show->synopsis_fr;
        saveLogMessage($idLog, $logMessage);

        $show->synopsis = $this->inputs['resume_en'];
        # Résumé EN de la série
        $logMessage = '>>Résumé EN : ' . $show->synopsis;
        saveLogMessage($idLog, $logMessage);

        $show->format = $this->inputs['format'];
        # Format de la série
        $logMessage = '>>Format : ' . $show->format;
        saveLogMessage($idLog, $logMessage);

        $show->encours = $this->inputs['encours'];
        # La série est en cours ?
        $logMessage = '>>>En cours : ' . $show->encours;
        saveLogMessage($idLog, $logMessage);

        $show->diffusion_us = $this->inputs['diffusion_us'];
        # Diffusion US de la série
        $logMessage = '>>Diffusion US : ' . $show->diffusion_us;
        saveLogMessage($idLog, $logMessage);

        $dateTemp = date_create($show->diffusion_us);
        $show->annee = date_format($dateTemp, 'Y');
        # Année de diffusion de la série
        $logMessage = '>>Année : ' . $show->annee;
        saveLogMessage($idLog, $logMessage);

        $show->diffusion_fr = $this->inputs['diffusion_fr'];
        # Diffusion FR de la série
        $logMessage = '>>Diffusion FR : ' . $show->diffusion_fr;
        saveLogMessage($idLog, $logMessage);

        $show->particularite = $this->inputs['particularite'];
        # Particularité de la série
        $logMessage = '>>>>Particularité : ' . $show->particularite;
        saveLogMessage($idLog, $logMessage);

        $show->taux_erectile = $this->inputs['taux_erectile'];
        # Taux Erectile
        $logMessage = '>>Taux érectile: ' . $show->taux_erectile;
        saveLogMessage($idLog, $logMessage);

        $show->avis_rentree = $this->inputs['avis_rentree'];
        # Avis sur la série
        $logMessage = '>>Avis : ' . $show->avis_rentree;
        saveLogMessage($idLog, $logMessage);

        $show->save();

        /*
        |--------------------------------------------------------------------------
        | Ajout des informations sur les genres de la série
        |--------------------------------------------------------------------------
        */

        $genres = $this->inputs['genres'];
        $listGenres = null;

        if (empty($genres)) {
            $show->genres()->sync([]);
        }
        else {
            $logMessage = '>>GENRES';
            saveLogMessage($idLog, $logMessage);
            $genres = explode(',', $genres);
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
                    $logMessage = '>>>Ajout du genre : ' . $genre . '.';
                    saveLogMessage($idLog, $logMessage);
                    # On prépare le nouveau genre
                    $genre_ref = new Genre([
                        'name' => $genre,
                        'genre_url' => $genre_url
                    ]);

                    # Et on le sauvegarde ne passant par l'objet Show pour créer le lien entre les deux
                    $show->genres()->save($genre_ref);

                }
                $listGenres[] = $genre_ref->id;
            }
            $show->genres()->sync($listGenres);
        }

        /*
        |--------------------------------------------------------------------------
        | Ajout des informations sur les chaines de la série
        |--------------------------------------------------------------------------
        */

        $channels = $this->inputs['channels'];
        $listChannels = null;

        if (empty($channels)) {
            $show->channels()->sync([]);
        }
        else {
            $logMessage = '>>CHAINES';
            saveLogMessage($idLog, $logMessage);
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
                    $logMessage = '>>>Ajout de la chaine : ' . $channel . '.';
                    saveLogMessage($idLog, $logMessage);
                    # On prépare la nouvelle nationalité
                    $channel_ref = new Channel([
                        'name' => $channel,
                        'channel_url' => $channel_url
                    ]);

                    # On crée la chaine si elle n'exite pas
                    $channel_ref->save();
                }
                $listChannels[] = $channel_ref->id;
            }
            $show->channels()->sync($listChannels);
        }

        /*
        |--------------------------------------------------------------------------
        | Ajout des informations sur les nationalités de la série
        |--------------------------------------------------------------------------
        */

        $nationalities = $this->inputs['nationalities'];
        $listNationalities = null;

        if (empty($nationalities)) {
            $show->nationalities()->sync([]);
        }
        else {
            $logMessage = '>>NATIONALITES';
            saveLogMessage($idLog, $logMessage);
            $nationalities = explode(',', $nationalities);

            # Pour chaque nationalité
            foreach ($nationalities as $nationality) {
                # On supprime les espaces
                $nationality = trim($nationality);
                # On met en forme l'URL
                $nationality_url = Str::slug($nationality);
                # On verified si la nationalité existe déjà en base
                $nationality_ref = Nationality::where('nationality_url', $nationality_url)->first();

                # Si elle n'existe pas
                if (is_null($nationality_ref)) {
                    $logMessage = '>>>Ajout de la nationalité : ' . $nationality . '.';
                    saveLogMessage($idLog, $logMessage);
                    # On prépare la nouvelle nationalité
                    $nationality_ref = new Nationality([
                        'name' => $nationality,
                        'nationality_url' => $nationality_url
                    ]);

                    # Et on crée la nouvelle nationlité
                    $nationality_ref->save();
                }
                $listNationalities[] = $nationality_ref->id;
            }
            $show->nationalities()->sync($listNationalities);
        }

        /*
        |--------------------------------------------------------------------------
        | Ajout des informations sur les créateurs de la série
        |--------------------------------------------------------------------------
        */

        $creators = $this->inputs['creators'];
        $listCreators = null;

        if (empty($creators)) {
            $show->creators()->sync([]);
        }
        else {
            $logMessage = '>>CREATEURS';
            saveLogMessage($idLog, $logMessage);
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
                    $logMessage = '>>>Ajout du créateur : ' . $creator . '.';
                    saveLogMessage($idLog, $logMessage);
                    # On prépare le nouveau créateur
                    $creator_ref = new Artist([
                        'name' => $creator,
                        'artist_url' => $creator_url
                    ]);

                    # Et on le sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $creator_ref->save();
                }
                $listCreators[] = $creator_ref->id;
            }
            $show->creators()->sync($listCreators, ['profession' => 'creator']);
        }

        endJob($idLog);
    }
}
