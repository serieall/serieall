<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserChangeInfosRequest;
use App\Repositories\CommentRepository;
use App\Repositories\RateRepository;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;
use App\Http\Requests\changePasswordRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use View;
use Response;
use Illuminate\Support\Facades\Log;
use App\Charts\RateSummary;

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
        $time_passed_shows = getTimePassedOnShow($this->rateRepository, $user->id);

        $rates = $this->rateRepository->getRateByUserID($user->id);

        return view('users.profile', compact('user', 'rates', 'avg_user_rates', 'comment_fav', 'comment_def', 'comment_neu', 'nb_comments', 'time_passed_shows'));
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
                $rates = $this->rateRepository->getRatesAggregateByShowForUser($user->id, "avg_rate DESC");
            } else if ($action == "nb_rate") {
                $rates = $this->rateRepository->getRatesAggregateByShowForUser($user->id, "nb_rate DESC");
            } else if($action == "time") {
                $rates = $this->rateRepository->getRatesAggregateByShowForUser($user->id, "minutes DESC");
            } else {
                $rates = $this->rateRepository->getRatesAggregateByShowForUser($user->id, "sh.name");
            }
            return Response::json(View::make('users.rates_cards', ['rates' => $rates])->render());
        }
        else {
            $nb_minutes = 0;
            $rates = $this->rateRepository->getRatesAggregateByShowForUser($user->id, "sh.name");
            foreach($rates as $rate) {
                $nb_minutes = $nb_minutes + $rate->minutes;
            }
            Carbon::setLocale('fr');
            $time_passed_shows = CarbonInterval::fromString($nb_minutes . 'm')->cascade()->forHumans();

            $chart = new RateSummary;
            $chart
                ->height(300)
                ->title('Récapitulatif des notes')
                ->labels($chart_rates->pluck("rate"))
                ->dataset('Nombre de notes', 'line', $chart_rates->pluck("total"));

            return view('users.rates', compact('user', 'rates', 'chart_rates', 'chart', 'avg_user_rates', 'comment_fav', 'comment_def', 'comment_neu', 'nb_comments', 'time_passed_shows'));
        }
    }

    /**
     * @param $userURL
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getComments($userURL) {
        $user = $this->userRepository->getUserByURL($userURL);

        $all_rates = $this->rateRepository->getAllRateByUserID($user->id);
        $avg_user_rates = $all_rates->select(DB::raw('trim(round(avg(rate),2))+0 avg, count(*) nb_rates'))->first();
        $time_passed_shows = getTimePassedOnShow($this->rateRepository, $user->id);

        $comments = $this->commentRepository->getCommentByUserIDThumbNotNull($user->id);
        $nb_comments = $this->commentRepository->countCommentByUserIDThumbNotNull($user->id);
        $comment_fav = $comments->where('thumb', '=', 1)->first();
        $comments_fav = $comment_fav ? $comment_fav->total : 0;
        $comment_neu = $comments->where('thumb', '=', 2)->first();
        $comments_neu = $comment_neu ? $comment_neu->total : 0;
        $comment_def = $comments->where('thumb', '=', 3)->first();
        $comments_def = $comment_def ? $comment_def->total : 0;

        $chart = new RateSummary;
        $chart
            ->height(300)
            ->title('Récapitulatif des commentaires')
            ->labels(["Favorables", "Neutres", "Défavorables"])
            ->dataset('Commentaires', 'pie', [$comments_fav,$comments_neu,$comments_def])
            ->color(['#21BA45','#767676','#db2828']);

        return view('users.comments', compact('user', 'time_passed_shows', 'avg_user_rates', 'nb_comments', 'comment_fav', 'comment_neu', 'comment_def', 'chart'));
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
