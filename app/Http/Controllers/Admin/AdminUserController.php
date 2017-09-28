<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Jobs\UserStore;
use App\Jobs\UserUpdate;
use Illuminate\Support\Facades\Auth;

use App\Repositories\UserRepository;
use App\Jobs\UserDelete;

class AdminUserController extends Controller
{
    protected $userRepository;

    /**
     * AdminUserController constructor.
     *
     * @param UserRepository $userRepository
     * @internal param SeasonRepository $seasonRepository
     * @internal param ShowRepository $showRepository
     * @internal param ArtistRepository $artistRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Affiche l'index de l'administation des utilisateurs
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // On récupère la liste des utilisateurs
        $users = $this->userRepository->getAllUsers();

        // On retourne la vue
        return view('admin.users.index', compact('users'));
    }

    /**
     * Affiche le formulaire de création d'utilisateur
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Ajoute un nouvel utilisateur
     *
     * @param UserStoreRequest $request
     * @return string
     */
    public function store(UserStoreRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        $this->dispatch(new UserStore($inputs));

        return redirect()->route('admin.users.index')
            ->with('status_header', 'Ajout d\'un utilisateur')
            ->with('status', 'La demande d\'ajout a été envoyée au serveur. Il la traitera dès que possible.');
    }

    /**
     * Affiche le formulaire d'édition de l'utilisateur
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->userRepository->getUserByID($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Met à jour un utilisateur
     *
     * @param UserUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @internal param $id
     */
    public function update(UserUpdateRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        dispatch(new UserUpdate($inputs));

        return redirect()->route('admin.users.index')
            ->with('status_header', 'Modification d\'un utilisateur')
            ->with('status', 'La demande de modification a été envoyée au serveur. Il la traitera dès que possible.');
    }

    /**
     * Bannir ou débannir un utilisateur
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ban($id)
    {
        $user = $this->userRepository->getUserByID($id);
        $userID = Auth::user()->id;

        $logID = initJob($userID, 'Ban', 'User', $user->id);

        if($user->suspended == 1)
        {
            $logMessage = 'Déban de l\'utilisateur ' . $user->username;
            saveLogMessage($logID, $logMessage);
            $user->suspended = 0;
        }
        else
        {
            $logMessage = 'Ban de l\'utilisateur ' . $user->username;
            saveLogMessage($logID, $logMessage);
            $user->suspended = 1;
        }

        $user->save();
        endJob($logID);

        return view('admin.users.edit', compact('user'));
    }
}
