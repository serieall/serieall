<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Services\ActivationService;
use App\Packages\Hashing\YourHasher;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $activationService;
    protected $hashingProvider;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ActivationService $activationService, YourHasher $hashingProvider)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->activationService = $activationService;
        $this->hashingProvider = $hashingProvider;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        # Si le mot de passe n'st pas hashé avec Bcrypt
        if($this->hashingProvider->needsRehash(Auth::user()->password)){
            # On regénre un mot de passe avevc Bcrypt
            Auth::user()->password = $this->hashingProvider->make($request->password);
            # On sauvegarde l'utilisateur
            Auth::user()->save();
        }

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    public function authenticated(Request $request, $user)
    {
        if (! $user->activated) {
            $this->activationService->sendActivationMail($user);
            auth()->logout();
            return back()->with('warning', 'Vous devez valider votre adresse E-mail. Nous vous avons envoyé un code de validation.');
        }
        return redirect()->intended($this->redirectPath());
    }

    public function activateUser($token)
    {
        if ($user = $this->activationService->activateUser($token)) {
            return redirect()->back();
        }
        abort(404);
    }
}