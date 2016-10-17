<?php

namespace App\Jobs;


use App\Models\Channel;
use App\Models\Nationality;
use App\Models\Show;
use App\Models\Genre;
use App\Models\Artist;
use App\Models\Temp;

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
            $show_new->name_fr = $show_fr->seriesName;
        }
        if(!is_null($show_fr->overview)) {
            $show_new->synopsis = $show_fr->overview;
        }
        else {
            if(!is_null($show_en->overview)) {
                $show_new->synopsis = $show_en->overview;
            }
            else{
                $show_new->synopsis = 'TBA';
            }
        }

        $show_new->thetvdb_id = $theTVDBID;                         # L'ID de TheTVDB
        $show_new->name = $show_en->seriesName;                # Le nom de la série
        $show_new->format = $show_en->runtime;                 # Le format de la série
        $show_new->diffusion_us = $show_en->firstAired;        # Date de diffusion US
        $show_new->diffusion_fr = $this->inputs['diffusion_fr'];    # Date de diffusion FR
        $show_new->taux_erectile = $this->inputs['taux_erectile'];  # Le taux érectile
        $show_new->avis_rentree = $this->inputs['avis_rentree'];    # Le taux érectile


        # Le champ en cours doit être à 1 si la série est en cours et à 0 dans le cas contraire
        if ($show_en->status == 'Continuing'){
            $show_new->encours = 1;
        }
        else
        {
            $show_new->encours = 0;
        }

        # Pour l'année, on va parser le champ firstAired et récupérer uniquement l'année
        $dateTemp = date_create($show_en->firstAired);     # On transforme d'abord le texte récupéré par la requête en date
        $show_new->annee = date_format($dateTemp, "Y");         # Ensuite on récupère l'année

        # Utilisation de la méthode Slug pour l'URL
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
                    # On prépare le nouveau genre
                    $genre_ref = new Genre([
                        'name' => $genre,
                        'genre_url' => $genre_url
                    ]);

                    # Et on le sauvegarde ne passant par l'objet Show pour créer le lien entre les deux
                    $show_new->genres()->save($genre_ref);

                } else {
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
                    # On prépare le nouveau créateur
                    $creator_ref = new Artist([
                        'name' => $creator,
                        'artist_url' => $creator_url
                    ]);

                    # Et on le sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $show_new->artists()->save($creator_ref, ['profession' => 'creator']);
                } else {
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
                    # On prépare la nouvelle nationalité
                    $nationality_ref = new Nationality([
                        'name' => $nationality,
                        'nationality_url' => $nationality_url
                    ]);

                    # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $show_new->nationalities()->save($nationality_ref);
                } else {
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
                    # On prépare la nouvelle nationalité
                    $channel_ref = new Channel([
                        'name' => $channel,
                        'channel_url' => $channel_url
                    ]);

                    # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $show_new->channels()->save($channel_ref);
                } else {
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
                # Récupération du rôle
                $actorRole = $actor->role;
                if (is_null($actorRole)) {
                    $actorRole = 'TBA';
                }

                # Récupération du nom de l'acteur
                $actorName = $actor->name;

                # On supprime les espaces
                $actor = trim($actorName);
                # On met en forme l'URL
                $actor_url = Str::slug($actor);
                # Vérification de la présence de l'acteur
                $actor_ref = Artist::where('artist_url', $actor_url)->first();

                # Si elle n'existe pas
                if (is_null($actor_ref)) {
                    # On prépare la nouvelle saison
                    $actor_ref = new Artist([
                        'name' => $actor,
                        'artist_url' => $actor_url
                    ]);

                    # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                    $show_new->artists()->save($actor_ref, ['profession' => 'actor', 'role' => $actorRole]);
                } else {
                    # Si il existe, on crée juste le lien
                    $show_new->artists()->attach($actor_ref->id, ['profession' => 'actor', 'role' => $actorRole]);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Lancement du job de création de la ou des saisons
        |--------------------------------------------------------------------------
        */
        dispatch(new AddEpisodesFromTVDB($theTVDBID, $show_new));

    }
}
