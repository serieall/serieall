<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Notifications\DatabaseNotification;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\EpisodeRepository;
use App\Repositories\RateRepository;
use App\Repositories\ShowRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;use Symfony\Component\VarDumper\Cloner\Data;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Request::ajax()) {
            
        } else {
            # Get last Rates and comments
            $lastRates = $this->rateRepository->getLast20Rates();
            $lastRates->map(function ($rate) {
                $rate->type = "rate";

            });
            $lastComments = $this->commentRepository->getLast20Comments();
            $lastComments->map(function ($comment) {
                $comment->type = "comment";

            });

            # Merge collections of comments and rates
            $fil_actu = $lastRates->merge($lastComments)->sortByDesc('created_at');
            $actu_mode = "all";

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

            return view('pages.home', compact('fil_actu', 'shows_moment', 'articles', 'planning', 'dates', 'last_added_shows', 'actu_mode'));
        }

    }
}
