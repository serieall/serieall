<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserChangeInfosRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;
use App\Http\Requests\changePasswordRequest;


/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    protected $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Renvoi vers la page users/index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
       $users = $this->userRepository->getAllUsers();

       return view('users.index', compact('users'));
    }

    /**
     * Renvoi vers la page users/profile
     *
     * @param $userURL
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getProfile($userURL){
        $user = $this->userRepository->getUserByURL($userURL);

        return view('users.profile', compact('user'));
    }

    /**
     * Affiche le formulaire de modification des paramètres
     *
     * @param $userURL
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getParameters($userURL){
        $user = $this->userRepository->getUserByURL($userURL);

        return view('users.parameters', compact('user'));
    }

    /**
     * L'utilisateur change lui-même ses informations personnelles
     *
     * @param UserChangeInfosRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeInfos(UserChangeInfosRequest $request): RedirectResponse
    {
        $user = Auth::user();
        if ($user !== null) {
            $user->email = $request->email;
            $user->antispoiler = $request->antispoiler;
            $user->twitter = $request->twitter;
            $user->facebook = $request->facebook;
            $user->website = $request->website;
            $user->edito = $request->edito;

            $user->save();

            $state = 'success';
            $message = 'Vos informations personnelles ont été modifiées !';
        }
        else {
            $state = 'error';
            $message = 'Vous devez vous connecter pour pouvoir modifier vos informations personnelles.';
        }

        return redirect()->back()->with($state, $message);
    }

    /**
     * Changement du mot de passe de l'utilisateur
     *
     * @param changePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(changePasswordRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $password = $request->password;

        if ($user !== null) {
            if (Hash::check($password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();

                $state = 'success';
                $message = 'Votre mot de passe a bien été modifié !';
            }
            else {
                $state = 'warning';
                $message = 'Votre mot de passe actuel ne correspond pas à celui saisi.';
            }
        }
        else {
            $state = 'error';
            $message = 'Vous devez être connecté pour pouvoir changer votre mot de passe.';
        }

        return redirect()->back()->with($state, $message);
    }
}
