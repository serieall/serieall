<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Charts\RateSummary;
use App\Http\Requests\changePasswordRequest;
use App\Http\Requests\FollowShowRequest;
use App\Http\Requests\NotificationRequest;
use App\Http\Requests\UserChangeInfosRequest;
use App\Repositories\CommentRepository;
use App\Repositories\RateRepository;
use App\Repositories\ShowRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use Response;
use View;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    protected $userRepository;
    protected $rateRepository;
    protected $commentRepository;
    protected $showRepository;

    /**
     * UserController constructor.
     */
    public function __construct(
        UserRepository $userRepository,
        RateRepository $rateRepository,
        CommentRepository $commentRepository,
        ShowRepository $showRepository
    ) {
        $this->userRepository = $userRepository;
        $this->rateRepository = $rateRepository;
        $this->commentRepository = $commentRepository;
        $this->showRepository = $showRepository;
    }

    /**
     * Renvoi vers la page users/index.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = $this->userRepository->list();

        return view('users.index', compact('users'));
    }

    /**
     * Renvoi vers la page users/profile.
     *
     * @param $userURL
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getProfile($userURL)
    {
        $user = $this->userRepository->getByURL($userURL);

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
     * Renvoi vers la page users/rates.
     *
     * @param $userURL
     * @param $action
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|Response
     */
    public function getRates($userURL, $action = '')
    {
        $user = $this->userRepository->getByURL($userURL);

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
            if ('avg' == $action) {
                $rates = $this->rateRepository->getRatesAggregateByShowForUser($user->id, 'avg_rate DESC');
            } elseif ('nb_rate' == $action) {
                $rates = $this->rateRepository->getRatesAggregateByShowForUser($user->id, 'nb_rate DESC');
            } elseif ('time' == $action) {
                $rates = $this->rateRepository->getRatesAggregateByShowForUser($user->id, 'minutes DESC');
            } else {
                $rates = $this->rateRepository->getRatesAggregateByShowForUser($user->id, 'sh.name');
            }

            return Response::json(View::make('users.rates_cards', ['rates' => $rates])->render());
        } else {
            $nb_minutes = 0;
            $rates = $this->rateRepository->getRatesAggregateByShowForUser($user->id, 'sh.name');
            foreach ($rates as $rate) {
                $nb_minutes = $nb_minutes + $rate->minutes;
            }
            Carbon::setLocale('fr');
            $time_passed_shows = CarbonInterval::fromString($nb_minutes.'m')->cascade()->forHumans();

            $chart = new RateSummary();
            $chart
                ->height(300)
                ->title('Récapitulatif des notes')
                ->labels($chart_rates->pluck('rate'))
                ->dataset('Nombre de notes', 'line', $chart_rates->pluck('total'));

            $chart->options([
                'yAxis' => [
                    'min' => 0,
                ],
            ]);

            return view('users.rates', compact('user', 'rates', 'chart_rates', 'chart', 'avg_user_rates', 'comment_fav', 'comment_def', 'comment_neu', 'nb_comments', 'time_passed_shows'));
        }
    }

    /**
     * @param $userURL
     * @param string $action
     * @param string $filter
     * @param string $tri
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function getComments($userURL, $action = '', $filter = '', $tri = '')
    {
        $user = $this->userRepository->getByURL($userURL);

        switch ($filter) {
            case 1:
                $filter = [1];
                break;
            case 2:
                $filter = [2];
                break;
            case 3:
                $filter = [3];
                break;
            default:
                $filter = [1, 2, 3];
                break;
        }

        switch ($tri) {
            case 1:
                $tri = 'shows.name';
                break;
            case 2:
                $tri = 'comments.id';
                break;
            default:
                $tri = 'shows.name';
                break;
        }

        if (Request::ajax()) {
            if ('show' == $action) {
                $comments = $this->commentRepository->getCommentsShowForProfile($user->id, 'show', $filter, $tri);
            } elseif ('season' == $action) {
                $comments = $this->commentRepository->getCommentsSeasonForProfile($user->id, 'season', $filter, $tri);
            } elseif ('episode' == $action) {
                $comments = $this->commentRepository->getCommentsEpisodeForProfile($user->id, 'episode', $filter, $tri);
            }

            return Response::json(View::make('users.comments_cards', ['comments' => $comments])->render());
        } else {
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

            $comments_shows = $this->commentRepository->getCommentsShowForProfile($user->id, 'show', $filter, $tri);
            $comments_seasons = $this->commentRepository->getCommentsSeasonForProfile($user->id, 'season', $filter, $tri);
            $comments_episodes = $this->commentRepository->getCommentsEpisodeForProfile($user->id, 'episode', $filter, $tri);

            $chart = new RateSummary();
            $chart
                ->height(300)
                ->title('Récapitulatif des avis')
                ->labels(['Favorables', 'Neutres', 'Défavorables'])
                ->dataset('Avis', 'pie', [$comments_fav, $comments_neu, $comments_def])
                ->color(['#21BA45', '#767676', '#db2828']);

            return view('users.comments', compact('user', 'time_passed_shows', 'avg_user_rates', 'nb_comments', 'comment_fav', 'comment_neu', 'comment_def', 'chart', 'comments_shows', 'comments_seasons', 'comments_episodes'));
        }
    }

    /**
     * Affiche le formulaire de modification des paramètres.
     *
     * @param $userURL
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getParameters($userURL)
    {
        $user = $this->userRepository->getByURL($userURL);

        return view('users.parameters', compact('user'));
    }

    /**
     * L'utilisateur change lui-même ses informations personnelles.
     */
    public function changeInfos(UserChangeInfosRequest $request): RedirectResponse
    {
        $user = Auth::user();
        if (null !== $user) {
            $user->email = $request->email;
            $user->antispoiler = $request->antispoiler;
            $user->twitter = $request->twitter;
            $user->facebook = $request->facebook;
            $user->website = $request->website;
            $user->edito = $request->edito;

            $user->save();

            $state = 'success';
            $message = 'Vos informations personnelles ont été modifiées !';
        } else {
            $state = 'error';
            $message = 'Vous devez vous connecter pour pouvoir modifier vos informations personnelles.';
        }

        return redirect()->back()->with($state, $message);
    }

    /**
     * Changement du mot de passe de l'utilisateur.
     */
    public function changePassword(changePasswordRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $password = $request->password;

        if (null !== $user) {
            if (Hash::check($password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();

                $state = 'success';
                $message = 'Votre mot de passe a bien été modifié !';
            } else {
                $state = 'warning';
                $message = 'Votre mot de passe actuel ne correspond pas à celui saisi.';
            }
        } else {
            $state = 'error';
            $message = 'Vous devez être connecté pour pouvoir changer votre mot de passe.';
        }

        return redirect()->back()->with($state, $message);
    }

    /**
     * @param $user_url
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRanking($user_url)
    {
        $user = $this->userRepository->getByURL($user_url);

        $all_rates = $this->rateRepository->getAllRateByUserID($user->id);
        $avg_user_rates = $all_rates->select(DB::raw('trim(round(avg(rate),2))+0 avg, count(*) nb_rates'))->first();
        $time_passed_shows = getTimePassedOnShow($this->rateRepository, $user->id);

        $comments = $this->commentRepository->getCommentByUserIDThumbNotNull($user->id);
        $nb_comments = $this->commentRepository->countCommentByUserIDThumbNotNull($user->id);
        $comment_fav = $comments->where('thumb', '=', 1)->first();
        $comment_neu = $comments->where('thumb', '=', 2)->first();
        $comment_def = $comments->where('thumb', '=', 3)->first();

        $top_shows = $this->rateRepository->getRankingShowsByUsers($user->id, 'DESC');
        $flop_shows = $this->rateRepository->getRankingShowsByUsers($user->id, 'ASC');
        $top_seasons = $this->rateRepository->getRankingSeasonsByUsers($user->id, 'DESC');
        $flop_seasons = $this->rateRepository->getRankingSeasonsByUsers($user->id, 'ASC');
        $top_episodes = $this->rateRepository->getRankingEpisodesByUsers($user->id, 'DESC');
        $flop_episodes = $this->rateRepository->getRankingEpisodesByUsers($user->id, 'ASC');
        $top_pilot = $this->rateRepository->getRankingPilotByUsers($user->id, 'DESC');
        $flop_pilot = $this->rateRepository->getRankingPilotByUsers($user->id, 'ASC');

        return view('users.ranking', compact('user', 'avg_user_rates', 'time_passed_shows', 'nb_comments', 'comment_fav', 'comment_neu', 'comment_def', 'top_shows', 'flop_shows', 'top_seasons', 'flop_seasons', 'top_episodes', 'flop_episodes', 'top_pilot', 'flop_pilot'));
    }

    /**
     * Get Followed Shows.
     *
     * @param $user_url
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShows($user_url)
    {
        $user = $this->userRepository->getByURL($user_url);

        $all_rates = $this->rateRepository->getAllRateByUserID($user->id);
        $avg_user_rates = $all_rates->select(DB::raw('trim(round(avg(rate),2))+0 avg, count(*) nb_rates'))->first();
        $time_passed_shows = getTimePassedOnShow($this->rateRepository, $user->id);

        $comments = $this->commentRepository->getCommentByUserIDThumbNotNull($user->id);
        $nb_comments = $this->commentRepository->countCommentByUserIDThumbNotNull($user->id);
        $comment_fav = $comments->where('thumb', '=', 1)->first();
        $comment_neu = $comments->where('thumb', '=', 2)->first();
        $comment_def = $comments->where('thumb', '=', 3)->first();

        $followed_shows = $this->showRepository->getShowFollowedByUser($user->id);
        $in_progress_shows = $followed_shows->where('state', '=', 1);
        $on_break_shows = $followed_shows->where('state', '=', 2);
        $completed_shows = $followed_shows->where('state', '=', 3);
        $abandoned_shows = $followed_shows->where('state', '=', 4);
        $to_see_shows = $followed_shows->where('state', '=', 5);

        return view('users.shows', compact('user', 'avg_user_rates', 'time_passed_shows', 'nb_comments', 'comment_fav', 'comment_neu', 'comment_def', 'in_progress_shows', 'on_break_shows', 'completed_shows', 'abandoned_shows', 'to_see_shows'));
    }

    /**
     * Follow Show.
     *
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function followShow(FollowShowRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        if (Request::ajax()) {
            $user = $this->userRepository->getByID($inputs['user_id']);

            if (!empty($inputs['shows'])) {
                $show = explode(',', $inputs['shows']);
                if (!isset($inputs['message'])) {
                    $message = '';
                } else {
                    $message = $inputs['message'];
                }

                foreach ($show as $s) {
                    if ($user->shows->contains($s)) {
                        $user->shows()->detach($s);
                    }
                }

                $user->shows()->attach($show, ['state' => $inputs['state'], 'message' => $message]);
            }

            if (1 == $inputs['state']) {
                $followed_shows = $this->showRepository->getShowFollowedByUser($user->id);
                $in_progress_shows = $followed_shows->where('state', '=', 1);

                return Response::json(View::make('users.shows_cards', ['shows' => $in_progress_shows, 'user' => $user])->render());
            } elseif (2 == $inputs['state']) {
                $followed_shows = $this->showRepository->getShowFollowedByUser($user->id);
                $on_break_shows = $followed_shows->where('state', '=', 2);

                return Response::json(View::make('users.shows_cards', ['shows' => $on_break_shows, 'user' => $user])->render());
            } elseif (3 == $inputs['state']) {
                $followed_shows = $this->showRepository->getShowFollowedByUser($user->id);
                $completed_shows = $followed_shows->where('state', '=', 3);

                return Response::json(View::make('users.shows_cards', ['shows' => $completed_shows, 'user' => $user])->render());
            } elseif (4 == $inputs['state']) {
                $followed_shows = $this->showRepository->getShowFollowedByUser($user->id);
                $abandoned_shows = $followed_shows->where('state', '=', 4);

                return Response::json(View::make('users.shows_abandoned_cards', ['shows' => $abandoned_shows, 'user' => $user])->render());
            } elseif (5 == $inputs['state']) {
                $followed_shows = $this->showRepository->getShowFollowedByUser($user->id);
                $to_see_shows = $followed_shows->where('state', '=', 5);

                return Response::json(View::make('users.shows_cards', ['shows' => $to_see_shows, 'user' => $user])->render());
            }
        }

        return 404;
    }

    /**
     * Follow Show.
     *
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function followShowFiche(FollowShowRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        if (Request::ajax()) {
            $user = $this->userRepository->getByID($inputs['user_id']);

            if (!empty($inputs['shows'])) {
                $show = explode(',', $inputs['shows']);
                if (!isset($inputs['message'])) {
                    $message = '';
                } else {
                    $message = $inputs['message'];
                }

                foreach ($show as $s) {
                    if ($user->shows->contains($s)) {
                        $user->shows()->detach($s);
                    }
                }

                $user->shows()->attach($show, ['state' => $inputs['state'], 'message' => $message]);
                $show = $this->showRepository->getShowByID($inputs['shows']);

                return Response::json(View::make('shows.actions_show', ['state_show' => $inputs['state'], 'show_id' => $inputs['shows'], 'completed_show' => $show->encours])->render());
            }
        }

        return 404;
    }

    /**
     * Unfollow a show.
     *
     * @param $show
     *
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function unfollowShow($show)
    {
        if (Request::ajax()) {
            $user = Auth::user();

            if ($user->shows->contains($show)) {
                $user->shows()->detach($show);
            }

            return Response::json(200);
        }

        return 404;
    }

    /**
     * Get planning for a particular user.
     *
     * @param $user_url
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPlanning($user_url)
    {
        $user = $this->userRepository->getByURL($user_url);

        $all_rates = $this->rateRepository->getAllRateByUserID($user->id);
        $avg_user_rates = $all_rates->select(DB::raw('trim(round(avg(rate),2))+0 avg, count(*) nb_rates'))->first();
        $time_passed_shows = getTimePassedOnShow($this->rateRepository, $user->id);

        $comments = $this->commentRepository->getCommentByUserIDThumbNotNull($user->id);
        $nb_comments = $this->commentRepository->countCommentByUserIDThumbNotNull($user->id);
        $comment_fav = $comments->where('thumb', '=', 1)->first();
        $comment_neu = $comments->where('thumb', '=', 2)->first();
        $comment_def = $comments->where('thumb', '=', 3)->first();

        $episodes_in_progress = $this->userRepository->getEpisodePlanning($user->id, 1);
        $episodes_on_break = $this->userRepository->getEpisodePlanning($user->id, 2);

        $events = [];

        foreach ($episodes_in_progress as $event) {
            $events[] = Calendar::event(
                $event->show_name.' - '.'Episode '.$event->season_name.'.'.sprintf('%02s', $event->numero),
                true,
                $event->diffusion_us,
                $event->diffusion_us,
                $event->id,
                [
                    'url' => route('episode.fiche', [$event->show_url, $event->season_name, $event->numero, $event->id]),
                    'backgroundColor' => '#1074b2',
                    'borderColor' => '#1074b2',
                ]
            );
        }

        foreach ($episodes_on_break as $event) {
            $events[] = Calendar::event(
                $event->show_name.' - '.'Episode '.$event->season_name.'.'.sprintf('%02s', $event->numero),
                true,
                $event->diffusion_us,
                $event->diffusion_us,
                $event->id,
                [
                    'url' => route('episode.fiche', [$event->show_url, $event->season_name, $event->numero, $event->id]),
                    'backgroundColor' => '#213d64',
                    'borderColor' => '#213d64',
                    'hover' => $event->show_name.' - '.'Episode '.$event->season_name.'.'.sprintf('%02s', $event->numero),
                ]
            );
        }

        $calendar = Calendar::addEvents($events)
            ->setOptions([
                'firstDay' => 1,
                'lang' => 'fr',
                'locale' => 'fr',
                'aspectRatio' => 2.5,
                'showNonCurrentDates' => false,
                'fixedWeekCount' => false,
            ])->setCallbacks(['eventRender' => 'function(eventObj, $el) {$el.popup({title: eventObj.title,content: eventObj.description,trigger: "hover",placement: "top",container: "body"});}']);

        return view('users.planning', compact('user', 'avg_user_rates', 'time_passed_shows', 'nb_comments', 'comment_fav', 'comment_neu', 'comment_def', 'calendar'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function markNotification(NotificationRequest $notificationRequest)
    {
        if (Request::ajax()) {
            $user = Auth::user();
            $notification = $user->Notifications->where('id', '=', $notificationRequest->notif_id)->first();

            if (is_null($notification->read_at)) {
                $notification->markAsRead();
            } else {
                if ('true' == $notificationRequest->markUnread) {
                    $notification->markAsUnRead();
                }
            }

            return Response::json('OK');
        }

        return 404;
    }

    /**
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function markNotifications()
    {
        if (Request::ajax()) {
            $user = Auth::user();

            $user->unreadNotifications->markAsRead();

            return Response::json('OK');
        }

        return 404;
    }

    public function getNotifications($user_url)
    {
        $user = $this->userRepository->getByURL($user_url);

        $all_rates = $this->rateRepository->getAllRateByUserID($user->id);
        $avg_user_rates = $all_rates->select(DB::raw('trim(round(avg(rate),2))+0 avg, count(*) nb_rates'))->first();
        $time_passed_shows = getTimePassedOnShow($this->rateRepository, $user->id);

        $comments = $this->commentRepository->getCommentByUserIDThumbNotNull($user->id);
        $nb_comments = $this->commentRepository->countCommentByUserIDThumbNotNull($user->id);
        $comment_fav = $comments->where('thumb', '=', 1)->first();
        $comment_neu = $comments->where('thumb', '=', 2)->first();
        $comment_def = $comments->where('thumb', '=', 3)->first();

        $notifications = $user->notifications()->paginate(30);

        return view('users.notifications', compact('user', 'avg_user_rates', 'time_passed_shows', 'nb_comments', 'comment_fav', 'comment_neu', 'comment_def', 'notifications'));
    }
}
