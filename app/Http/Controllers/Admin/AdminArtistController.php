<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\ArtistUpdateRequest;
use App\Http\Requests\ArtistCreateRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use App\Models\Artist;
use Illuminate\Support\Str;
use App\Repositories\ArtistRepository;
use App\Repositories\ShowRepository;

class AdminArtistController extends Controller
{

    protected $artistRepository;
    protected $showRepository;

    /**
     * AdminArtistController constructor.
     *
     * @param ArtistRepository $artistRepository
     * @param ShowRepository $showRepository
     */
    public function __construct(ArtistRepository $artistRepository, ShowRepository $showRepository)
    {
        $this->artistRepository = $artistRepository;
        $this->showRepository = $showRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $show_id
     * @return \Illuminate\Http\Response
     */
    public function create($show_id)
    {
        $show = $this->showRepository->getByID($show_id);

        return view('admin.artists.create', compact('show'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArtistCreateRequest $request
     * @return \Illuminate\Http\Response
     * @internal param $show_id
     * @internal param ShowCreateRequest|Request $request
     */
    public function store(ArtistCreateRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);
        $show = $this->showRepository->getByID($inputs['show_id']);

        foreach ($inputs['artists'] as $key => $actor) {
            # Récupération du nom de l'acteur
            $actorName = $actor['name'];

            # Récupération du rôle
            $actorRole = $actor['role'];

            # On supprime les espaces
            $actor_url = trim($actorName);
            # On met en forme l'URL
            $actor_url = Str::slug($actor_url);

            # Vérification de la présence de l'acteur
            $actor_ref = Artist::where('artist_url', $actor_url)->first();

            # Si elle n'existe pas
            if (is_null($actor_ref)) {
                # On prépare le nouvel acteur
                $actor_ref = new Artist([
                    'name' => $actor,
                    'artist_url' => $actor_url
                ]);

                # Et on la sauvegarde en passant par l'objet Show pour créer le lien entre les deux
                $show->artists()->save($actor_ref, ['profession' => 'actor', 'role' => $actorRole]);
            } else {
                # Si il existe, on vérifie qu'il n'a pas déjà un lien avec la série
                $actor_liaison = $actor_ref->shows()
                    ->where('shows.thetvdb_id', $inputs['show_id'])
                    ->where('artistables.profession', 'actor')
                    ->get()
                    ->toArray();

                if(empty($actor_liaison)) {
                    # On lie l'acteur à la série
                    $show->artists()->attach($actor_ref->id, ['profession' => 'actor', 'role' => $actorRole]);
                    # Ajout de l'image
                }
                else {
                    # On met à jour le rôle et la photo
                    $actor_ref->shows()->updateExistingPivot($show->id, ['role' => $request->role]);
                }
            }

            $photo = 'artists.' . $key . '.image';

            # Ajout de l'image
            if (Input::hasFile($photo) && Input::file($photo)->isValid()) {
                $destinationPath = public_path() . config('directories.actors');
                $extension = "jpg";
                $fileName = $actor_ref->artist_url . '.' . $extension;
                Input::file($photo)->move($destinationPath, $fileName);
            }
        }

        return response()->json();
    }

    /**
     * Affiche la liste des acteurs d'une série en fonction de son ID
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $show = $this->showRepository->getByID($id);
        $artists = $this->artistRepository->getActorsByShowID($show);

        return view('admin.artists.show', compact('artists', 'show'));
    }

    /**
     * Editer l'artiste
     *
     * @param $show_id
     * @param $artist_id
     * @return \Illuminate\Http\Response
     * @internal param $actor_id
     * @internal param int $id
     */
    public function edit($show_id, $artist_id)
    {
        $show = $this->showRepository->getByID($show_id);
        $artist = $this->artistRepository->getActorByShowID($show, $artist_id);

        return view('admin.artists.edit', compact('show', 'artist'));
    }


    /**
     * Modification d'un acteur
     *
     * @param ArtistUpdateRequest $request
     * @param $show_id
     * @param $artist_id
     * @return mixed
     */
    public function update(ArtistUpdateRequest $request, $show_id, $artist_id) {
        $show = $this->showRepository->getByID($show_id);
        $artist = $this->artistRepository->getActorByShowID($show, $artist_id);

        # Ajout de l'image
        if( Input::hasfile('image')) {
            if (Input::file('image')->isValid()) {
                $destinationPath = public_path() . config('directories.actors') ;
                $extension = "jpg";
                $fileName = $artist->artist_url . '.' . $extension;
                Input::file('image')->move($destinationPath, $fileName);
            }
        }

        # Modification du rôle
        $artist->shows()->updateExistingPivot($show->id, ['role' => $request->role]);

        return redirect()->route('admin.artists.show', $show->id)
            ->with('status_header', 'Modification')
            ->with('status', 'L\'acteur a été modifié');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $show_id
     * @param $artist_id
     * @return \Illuminate\Http\Response
     * @internal param $actor_id
     * @internal param int $id
     */
    public function unlinkShow($show_id, $artist_id)
    {
        $show = $this->showRepository->getByID($show_id);

        $show->artists()->detach($artist_id);

        return redirect()->back()
            ->with('status_header', 'Suppression')
            ->with('status', 'L\'acteur a été supprimé');
    }

    /**
     * Redirection JSON
     * @param $show_id
     * @return \Illuminate\Http\Response
     */
    public function redirectJSON($show_id)
    {
        return redirect()->route('admin.artists.show', $show_id)
            ->with('status_header', 'Acteurs en cours d\'ajout')
            ->with('status', 'La demande de création d\'acteurs a été effectuée. Le serveur la traitera dès que possible.');
    }

}