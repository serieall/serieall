<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\EpisodeRepository;
use App\Repositories\RateRepository;
use App\Repositories\ShowRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

    protected $rateRepository;
    protected $commentRepository;
    protected $articleRepository;
    protected $episodeRepository;
    protected $showRepository;

    /**
     * Create a new controller instance.
     * @param RateRepository $rateRepository
     * @param CommentRepository $commentRepository
     * @param ArticleRepository $articleRepository
     * @param EpisodeRepository $episodeRepository
     * @param ShowRepository $showRepository
     * @internal param ArticleRepository $articleRepository
     */
    public function __construct(RateRepository $rateRepository, CommentRepository $commentRepository, ArticleRepository $articleRepository, EpisodeRepository $episodeRepository, ShowRepository $showRepository)
    {
        $this->rateRepository = $rateRepository;
        $this->commentRepository = $commentRepository;
        $this->articleRepository = $articleRepository;
        $this->episodeRepository = $episodeRepository;
        $this->showRepository = $showRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        if(Request::ajax()) {
            $filter_home = Input::get('filter_home');

            if($filter_home == 'all') {
                # Get last Rates and comments
                $lastRates = $this->rateRepository->getLastRates(20);
                $lastRates->map(function ($rate) {
                    $rate->type = "rate";

                });
                $lastComments = $this->commentRepository->getLastComments(20);
                $lastComments->map(function ($comment) {
                    $comment->type = "comment";
                });

                # Merge collections of comments and rates
                $fil_actu = $lastRates->union($lastComments)->sortByDesc('created_at');
                $filter_home = "all";
            } elseif ($filter_home == 'rates') {
                # Get last Rates
                $lastRates = $this->rateRepository->getLastRates(40);
                $lastRates->map(function ($rate) {
                    $rate->type = "rate";

                });

                # Merge collections of comments and rates
                $fil_actu = $lastRates->sortByDesc('created_at');
                $filter_home = "rates";

            } else {
                # Get last comments
                $lastComments = $this->commentRepository->getLastComments(40);
                $lastComments->map(function ($comment) {
                    $comment->type = "comment";
                });

                # Merge collections of comments and rates
                $fil_actu = $lastComments->sortByDesc('created_at');
                $filter_home = "comments";
            }
            return Response::json(View::make('pages.home_fil_actu', ['fil_actu' => $fil_actu, 'filter_home' => $filter_home])->render());
        } else {
            # Get last Rates and comments
            $lastRates = $this->rateRepository->getLastRates(20);
            $lastRates->map(function ($rate) {
                $rate->type = "rate";

            });
            $lastComments = $this->commentRepository->getLastComments(20);
            $lastComments->map(function ($comment) {
                $comment->type = "comment";
            });

            # Merge collections of comments and rates
            $fil_actu = $lastRates->union($lastComments)->sortByDesc('created_at');
            $filter_home = "all";

            # Get show of the moment
            $shows_moment = $this->rateRepository->getShowsMoment();

            # Get Articles
            $articles = $this->articleRepository->getLast6Articles();

            # Get last added shows
            $last_added_shows = $this->showRepository->getLastAddedShows();

            # Get Planning on 14days
            $dates['yesterday'] = Carbon::now()->subDay()->format('Y-m-d');
            $dates['today'] = Carbon::now()->format('Y-m-d');
            $dates['tomorrow'] = Carbon::now()->addDay()->format('Y-m-d');
            $planning['yesterday'] = $this->episodeRepository->getPlanningHome('diffusion_us', $dates['yesterday']);
            $planning['today'] = $this->episodeRepository->getPlanningHome('diffusion_us', $dates['today']);
            $planning['tomorrow'] = $this->episodeRepository->getPlanningHome('diffusion_us', $dates['tomorrow']);

            return view('pages.home', compact('fil_actu', 'shows_moment', 'articles', 'planning', 'dates', 'last_added_shows', 'filter_home'));
        }
    }
}
