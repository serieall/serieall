<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserChangeInfosRequest;
use App\Repositories\CommentRepository;
use App\Repositories\RateRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;
use App\Http\Requests\changePasswordRequest;
use Illuminate\Support\Facades\DB;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Support\Facades\Request;
use View;
use Response;
use Illuminate\Support\Facades\Log;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    protected $userRepository;
    protected $rateRepository;
    protected $commentRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     * @param RateRepository $rateRepository
     * @param CommentRepository $commentRepository
     */
    public function __construct(UserRepository $userRepository, RateRepository $rateRepository, CommentRepository $commentRepository)
    {
        $this->userRepository = $userRepository;
        $this->rateRepository = $rateRepository;
        $this->commentRepository = $commentRepository;
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

        $all_rates = $this->rateRepository->getAllRateByUserID($user->id);
        $avg_user_rates = $all_rates->select(DB::raw('trim(round(avg(rate),2))+0 avg, count(*) nb_rates'))->first();

        $comments = $this->commentRepository->getCommentByUserIDThumbNotNull($user->id);
        $nb_comments = $this->commentRepository->countCommentByUserIDThumbNotNull($user->id);
        $comment_fav = $comments->where('thumb', '=', 1)->first();
        $comment_neu = $comments->where('thumb', '=', 2)->first();
        $comment_def = $comments->where('thumb', '=', 3)->first();

        $rates = $this->rateRepository->getRateByUserID($user->id);

        return view('users.profile', compact('user', 'rates', 'avg_user_rates', 'comment_fav', 'comment_def', 'comment_neu', 'nb_comments'));
    }

    /**
     * Renvoi vers la page users/rates
     *
     * @param $userURL
     * @param $action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|Response
     */
    public function getRates($userURL, $action = "") {
        $user = $this->userRepository->getUserByURL($userURL);

        $all_rates = $this->rateRepository->getAllRateByUserID($user->id);
        $all_rates_chart = $this->rateRepository->getAllRateByUserID($user->id);
        $avg_user_rates = $all_rates->select(DB::raw('trim(round(avg(rate),2))+0 avg, count(*) nb_rates'))->first();
        $chart_rates = $all_rates_chart->select('rate', DB::raw('count(*) as total'))->groupBy('rate')->get();

        $comments = $this->commentRepository->getCommentByUserIDThumbNotNull($user->id);
        $nb_comments = $this->commentRepository->countCommentByUserIDThumbNotNull($user->id);
        $comment_fav = $comments->where('thumb', '=', 1)->first();
        $comment_neu = $comments->where('thumb', '=', 2)->first();
        $comment_def = $comments->where('thumb', '=', 3)->first();

        if (Request::ajax()) {
            Log::info($action);
            if ($action == "avg") {
                $rates = $this->rateRepository->getRatesAggregateByShowForUser($user->id, "avg_rate");
                Log::debug("avg_rate");
            } else if ($action == "nb_rate") {
                $rates = $this->rateRepository->getRatesAggregateByShowForUser($user->id, "nb_rate DESC");
                Log::debug("nb_rate");
            } else {
                $rates = $this->rateRepository->getRatesAggregateByShowForUser($user->id, "sh.name");
                Log::debug("sh.name");
            }
            return Response::json(View::make('users.rates_cards', ['rates' => $rates])->render());
        }
        else {
            $rates = $this->rateRepository->getRatesAggregateByShowForUser($user->id, "sh.name");

            $chart = Charts::create('area', 'highcharts')
                ->title('Récapitulatif des notes')
                ->elementLabel('Nombre de notes')
                ->xAxisTitle('Notes')
                ->labels($chart_rates->pluck("rate"))
                ->values($chart_rates->pluck("total"))
                ->dimensions(0, 300);
            return view('users.rates', compact('user', 'rates', 'chart_rates', 'chart', 'avg_user_rates', 'comment_fav', 'comment_def', 'comment_neu', 'nb_comments'));
        }
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
