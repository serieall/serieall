<?php

namespace App\Jobs;

use App\Models\Show;
use App\Models\Genre;
use App\Models\Channel;
use App\Models\Nationality;
use App\Models\Artist;
use App\Models\List_log;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;


class UpdateShowManually implements ShouldQueue
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
        # ID User
        $userID = $this->inputs['user_id'];

        # Définition du nom du job
        $list_log = new List_log();
        $list_log->job = 'Mise à jour Manuelle';
        $list_log->object = 'Show';
        $list_log->object_id = mt_rand();
        $list_log->user_id = $userID;

        $list_log->save();

        $listLogID = $list_log->id;

        $logMessage = '>>>>>>>>>> Lancement du job d\'update <<<<<<<<<<';
        saveLogMessage($listLogID, $logMessage);

        /*
        |--------------------------------------------------------------------------
        | Ajout des informations sur la saison
        |--------------------------------------------------------------------------
        */

        $show = Show::where('id', '=', $this->inputs['id'])->first();

        $logMessage = '>SERIE';
        saveLogMessage($listLogID, $logMessage);

        $show->name_fr = $this->inputs['name_fr'];
        # Nom FR de la série
        $logMessage = '>>Nom FR : ' . $show->name_fr;
        saveLogMessage($listLogID, $logMessage);

        $show->synopsis = $this->inputs['resume'];
        # Résumé de la série
        $logMessage = '>>Résumé FR : ' . $show->synopsis;
        saveLogMessage($listLogID, $logMessage);

        $show->format = $this->inputs['format'];
        # Format de la série
        $logMessage = '>>Format : ' . $show->format;
        saveLogMessage($listLogID, $logMessage);

        $show->encours = $this->inputs['encours'];
        # La série est en cours ?
        $logMessage = '>>>En cours : ' . $show->encours;
        saveLogMessage($listLogID, $logMessage);

        $show->diffusion_us = $this->inputs['diffusion_us'];
        # Diffusion US de la série
        $logMessage = '>>Diffusion US : ' . $show->diffusion_us;
        saveLogMessage($listLogID, $logMessage);

        $dateTemp = date_create($show->diffusion_us);
        $show->annee = date_format($dateTemp, "Y");
        # Année de diffusion de la série
        $logMessage = '>>Année : ' . $show->annee;
        saveLogMessage($listLogID, $logMessage);

        $show->diffusion_fr = $this->inputs['diffusion_fr'];
        # Diffusion FR de la série
        $logMessage = '>>Diffusion FR : ' . $show->diffusion_fr;
        saveLogMessage($listLogID, $logMessage);

        $show->taux_erectile = $this->inputs['taux_erectile'];
        # Taux Erectile
        $logMessage = '>>Taux érectile: ' . $show->taux_erectile;
        saveLogMessage($listLogID, $logMessage);

        $show->avis_rentree = $this->inputs['avis_rentree'];
        # Avis sur la série
        $logMessage = '>>Avis : ' . $show->avis_rentree;
        saveLogMessage($listLogID, $logMessage);

        $show->save();

        /*
        |--------------------------------------------------------------------------
        | Ajout des informations sur les genres de la série
        |--------------------------------------------------------------------------
        */

        $genres = $this->inputs['genres'];

        if (!empty($genres)) {
            $logMessage = '>>GENRES';
            saveLogMessage($listLogID, $logMessage);
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
                    saveLogMessage($listLogID, $logMessage);
                    # On prépare le nouveau genre
                    $genre_ref = new Genre([
                        'name' => $genre,
                        'genre_url' => $genre_url
                    ]);

                    # Et on le sauvegarde ne passant par l'objet Show pour créer le lien entre les deux
                    $show->genres()->save($genre_ref);

                } else {
                    $logMessage = '>>>Liaison du genre : ' . $genre . '.';
                    saveLogMessage($listLogID, $logMessage);
                    # Si il existe, on crée juste le lien
                    $show->genres()->attach($genre_ref->id);
                }

                $listeGenres[] = $genre_ref->id;

                $show->genres()->sync($listeGenres);
            }
        }
        else
        {
            $show->genres()->sync([]);
        }

        /*
        |--------------------------------------------------------------------------
        | Ajout des informations sur les chaines de la série
        |--------------------------------------------------------------------------
        */

        $channels = $this->inputs['channels'];


        if (!empty($channels)) {
            $logMessage = '>>CHAINES';
            saveLogMessage($listLogID, $logMessage);
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
                    saveLogMessage($listLogID, $logMessage);
                    # On prépare la nouvelle nationalité
                    $channel_ref = new Channel([
                        'name' => $channel,
                        'channel_url' => $channel_url
                    ]);

                    # On crée la chaine si elle n'exite pas
                    $channel_ref->save();
                }

                $listeChannels[] = $channel_ref->id;
            }
            $show->channels()->sync($listeChannels);
        }
        else
        {
            $show->channels()->sync([]);
        }

        /*
        |--------------------------------------------------------------------------
        | Ajout des informations sur les nationalités de la série
        |--------------------------------------------------------------------------
        */

        $nationalities = $this->inputs['nationalities'];

        if (!empty($nationalities)) {
            $logMessage = '>>NATIONALITES';
            saveLogMessage($listLogID, $logMessage);
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
                    saveLogMessage($listLogID, $logMessage);
                    # On prépare la nouvelle nationalité
                    $nationality_ref = new Nationality([
                        'name' => $nationality,
                        'nationality_url' => $nationality_url
                    ]);

                    # Et on crée la nouvelle nationlité
                    $nationality_ref->save();
                }
                $listeNationalities[] = $nationality_ref->id;
            }
            $show->nationalities()->sync($listeNationalities);
        }
        else
        {
            $show->nationalities()->sync([]);
        }

        /*
        |--------------------------------------------------------------------------
        | Ajout des informations sur les créateurs de la série
        |--------------------------------------------------------------------------
        */

        $creators = $this->inputs['creators'];

        if (!empty($creators)) {
            $logMessage = '>>CREATEURS';
            saveLogMessage($listLogID, $logMessage);
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
                    saveLogMessage($listLogID, $logMessage);
                    # On prépare le nouveau créateur
                    $creator_ref = new Artist([
                        'name' => $creator,
                        'artist_url' => $creator_url
                    ]);

                    # Et on le sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $creator_ref->save();
                }
                $listeCreators[] = $creator_ref->id;
            }
            $show->creators()->sync($listeCreators, ['profession' => 'creator']);
        }
        else
        {
            $show->creators()->sync([]);
        }
    }
}
