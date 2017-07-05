<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\ArtistUpdateRequest;
use App\Http\Requests\ArtistCreateRequest;

use App\Jobs\ArtistStore;
use App\Jobs\ArtistUnlink;
use App\Jobs\ArtistUpdate;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;

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
     * Enregistrement d'un nouvel artist, et ajout de son image (l'accès en bas de données est parallélisé)
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

        $idLog = initJob($inputs['user_id'], 'Ajout Manuel', 'Artist', mt_rand());

        foreach ($inputs['artists'] as $key => $actor) {
            # Récupération du nom de l'acteur
            $actorName = $actor['name'];
            # Récupération du rôle
            $actorRole = $actor['role'];
            # On supprime les espaces
            $actor_url = Str::slug(trim($actorName));

            $this->dispatch(new ArtistStore($actorName, $actorRole, $show, $idLog));

            $photo = 'artists.' . $key . '.image';
            # Ajout de l'image
            if (Input::hasFile($photo) && Input::file($photo)->isValid()) {
                $destinationPath = public_path() . config('directories.actors');
                $extension = "jpg";
                $fileName = $actor_url . '.' . $extension;
                Input::file($photo)->move($destinationPath, $fileName);

                $logMessage = '> Ajout de l\'image ' . $fileName;
                saveLogMessage($idLog, $logMessage);
            }
        }

        endJob($idLog);
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
     * @return mixed
     * @internal param $show_id
     * @internal param $artist_id
     */
    public function update(ArtistUpdateRequest $request) {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        $show = $this->showRepository->getByID($inputs['show_id']);
        $artist = $this->artistRepository->getActorByShowID($show, $inputs['artist_id']);

        $idLog = initJob($inputs['user_id'], 'Edition', 'Artist', $artist->id);

        # Ajout de l'image
        if( Input::hasfile('image')) {
            if (Input::file('image')->isValid()) {
                $destinationPath = public_path() . config('directories.actors') ;
                $extension = "jpg";
                $fileName = $artist->artist_url . '.' . $extension;
                Input::file('image')->move($destinationPath, $fileName);

                $logMessage = '> Ajout de l\'image ' . $fileName;
                saveLogMessage($idLog, $logMessage);
            }
        }

        # Modification du rôle
        $this->dispatch(new ArtistUpdate($artist, $show->id, $inputs['role'], $idLog));

        return redirect()->route('admin.artists.show', $show->id)
            ->with('status_header', 'Modification d\'un acteur')
            ->with('status', 'La demande de modification a été envoyée au serveur. Il la traitera dès que possible.');
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
        $userID = Auth::user()->id;
        $show = $this->showRepository->getByID($show_id);

        dispatch(new ArtistUnlink($show, $artist_id, $userID));

        return redirect()->back()
            ->with('status_header', 'Suppression d\'un acteur')
            ->with('status', 'La demande de suppression a été envoyée au serveur. Il la traitera dès que possible.');
    }

    /**
     * Redirection
     * @param $show_id
     * @return \Illuminate\Http\Response
     */
    public function redirect($show_id)
    {
        return redirect()->route('admin.artists.show', $show_id)
            ->with('status_header', 'Acteurs en cours d\'ajout')
            ->with('status', 'La demande de création d\'acteurs a été effectuée. Le serveur la traitera dès que possible.');
    }

}