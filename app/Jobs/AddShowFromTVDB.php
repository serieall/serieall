<?php

namespace App\Jobs;

use App\Models\Artist;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use GuzzleHttp\Client;
use App\Models\Show;
use App\Models\Genre;
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
        $api_key = config('thetvdb.apikey');
        $api_username = config('thetvdb.username');
        $api_userkey = config('thetvdb.userkey');
        $api_url = config('thetvdb.url');
        $api_version = config('thetvdb.version');

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
        | L'objectif est de récupérer un token d'identification.
        | On passe en paramètre :
        |   - l'API Key,
        |   - le compte utilisateur,
        |   - La clé utilisateur.
        | Et on précise la version de l'API a utiliser.
        */
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

        $getShow_default = $client->request('GET', '/series/'. $theTVDBID, [
            'headers' => [
                'Accept' => 'application/json,application/vnd.thetvdb.v' . $api_version,
                'Authorization' => 'Bearer ' . $token,
            ]
        ])->getBody();

        /*
        |--------------------------------------------------------------------------
        | Décodage du JSON et vérification que la langue française existe sur The TVDB
        | Si la langue fr n'est pas renseignée, on met la variable languageFR à 'no'
        |--------------------------------------------------------------------------
        */
        $getShow_fr = json_decode($getShow_fr);
        $getShow_default = json_decode($getShow_default);

        if (isset($getShow_fr->errors->invalidLanguage)){
            $languageFR = false;
        }
        else{
            $languageFR = true;
        }

        $show_default = $getShow_default->data;


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

        # Si la langue française est renseignée
        if ($languageFR) {
            # On remplit les champs name_fr et synopsis en français
            $show_fr = $getShow_fr->data;

            $show_new->name_fr = $show_fr->seriesName;
            $show_new->synopsis = $show_fr->overview;
        }
        else
        {
            # Sinon on remplit uniquement le champ synopsis avec la langue par défaut
            $show_new->synopsis = $show_default->overview;
        }

        $show_new->thetvdb_id = $theTVDBID;                     # L'ID de TheTVDB
        $show_new->name = $show_default->seriesName;            # Le nom de la série
        $show_new->format = $show_default->runtime;             # Le format de la série
        $show_new->diffusion_us = $show_default->firstAired;    # Date de diffusion US

        # Le champ en cours doit être à 1 si la série est en cours et à 0 dans le cas contraire
        if ($show_default->status == 'Continuing'){
            $show_new->encours = 1;
        }
        else
        {
            $show_new->encours = 0;
        }

        # Pour l'année, on va parser le champ firstAired et récupérer uniquement l'année
        $dateTemp = date_create($show_default->firstAired);     # On transforme d'abord le texte récupéré par la requête en date
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

        $genres = $show_default->genre;

        # Pour chaque genre
        foreach ($genres as $genre) {
            # On supprime les espaces
            $genre = trim($genre);
            # On met en force l'URL
            $genre_url = Str::slug($genre);
            # On vérifie si le genre existe déjà en base
            $genre_ref = Genre::where('genre_url', $genre_url)->first();

            # Si il n'existe pas
            if(is_null($genre_ref))
            {
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

        /*
        |--------------------------------------------------------------------------
        | Gestion des créateurs
        |--------------------------------------------------------------------------
        | On commence par récupérer les créateurs du formulaire
        | Et on formate le tout et on applique le même traitement que pour les genres
        */
        if(isset($inputs['creators'])){
            $creators = $inputs['creators'];

            $creators = explode(',', $creators);

            # Pour chaque créateur
            foreach ($creators as $creator) {
                # On supprime les espaces
                $creator = trim($creator);
                # On met en force l'URL
                $creator_url = Str::slug($creator);
                # On vérifie si le genre existe déjà en base
                $creator_ref = Artist::where('creator_url', $genre_url)->first();

                # Si il n'existe pas
                if(is_null($creator_ref))
                {
                    # On prépare le nouveau genre
                    $creator_ref = new Artist([
                        'name' => $creator,
                        'artist_url' => $creator_url
                    ]);

                    # Et on le sauvegarde ne passant par l'objet Show pour créer le lien entre les deux
                    $show_new->artists()->save($creator_ref);

                } else {
                    # Si il existe, on crée juste le lien
                    $show_new->artists()->attach($creator_ref->id);
                }
            }
        }
    }
}
