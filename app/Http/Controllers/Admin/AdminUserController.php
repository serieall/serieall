<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return view('admin/users/index', compact('users'));
    }

    public function edit($id)
    {
        $user = $this->userRepository->getUserByID($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Supprime un utilisateur
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $userID = Auth::user()->id;

        dispatch(new UserDelete($id, $userID));

        return redirect()->back()
            ->with('status_header', 'Suppression d\'utilisateur')
            ->with('status', 'La demande de suppression a été envoyée au serveur. Il la traitera dès que possible.');
    }
}
