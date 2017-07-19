<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;
use App\Http\Requests\changePasswordRequest;


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
     * Renvoi vers la page users/profile
     *
     * @param $username
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProfile($username){
        $user = $this->userRepository->getUserByUsername($username);

        return view('users.profile', compact('user'));
    }

    /**
     * Changement du mot de passe de l'utilisateur
     *
     * @param changePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(changePasswordRequest $request){
        $user = Auth::user();
        $password = $request->password;

        if (Hash::check($password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->back()
                ->with('success', 'Votre mot de passe a été modifié !');
        }
        else{
            return redirect()->back()
                ->with('warning', 'Votre mot de passe actuel ne correspond pas à celui saisi.');
        }
    }
}
