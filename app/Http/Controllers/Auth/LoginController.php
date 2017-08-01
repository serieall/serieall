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
     * LoginController constructor.
     * @param ActivationService $activationService
     * @param YourHasher $hashingProvider
     */
    public function __construct(ActivationService $activationService, YourHasher $hashingProvider)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->activationService = $activationService;
        $this->hashingProvider = $hashingProvider;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        # Si le mot de passe n'est pas hashé avec Bcrypt
        if($this->hashingProvider->needsRehash(Auth::user()->password)){
            # On regénre un mot de passe avec Bcrypt
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

    /**
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticated(Request $request, $user)
    {
        if (! $user->activated) {
            $this->activationService->sendActivationMail($user);
            auth()->logout();
            return back()->with('warning', 'Vous devez valider votre adresse E-mail. Nous vous avons envoyé un code de validation.');
        }
        elseif ($user->suspended) {
            auth()->logout();
            return back()->with('warning', 'Votre compte a été bloqué.');
        }
        return redirect()->intended($this->redirectPath());
    }

    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activateUser($token)
    {
        if ($user = $this->activationService->activateUser($token)) {
            return redirect()->route('login')->with('success', 'Votre adresse E-Mail a été validée. Vous pouvez maintenant vous connecter.');
        }
        else {
            return redirect()->route('login')->with('error', 'Erreur lors de la validation de votre adresse mail. Vous l\'avez peut être déjà validée. En cas de problèmes, n\'hésitez pas à nous contacter à l\'adresse : serieall.fr@gmail.com');
        }
    }
}