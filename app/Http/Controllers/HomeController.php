<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Notifications\DatabaseNotification;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\RateRepository;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\Cloner\Data;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

    protected $rateRepository;
    protected $commentRepository;
    protected $articleRepository;

    /**
     * Create a new controller instance.
     * @param RateRepository $rateRepository
     * @param CommentRepository $commentRepository
     * @internal param ArticleRepository $articleRepository
     */
    public function __construct(RateRepository $rateRepository, CommentRepository $commentRepository, ArticleRepository $articleRepository)
    {
        $this->rateRepository = $rateRepository;
        $this->commentRepository = $commentRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

        # Get show of the moment
        $shows_moment = $this->rateRepository->getShowsMoment();

        # Get Articles
        $articles = $this->articleRepository->getLast6Articles();

        return view('pages.home', compact('fil_actu', 'shows_moment', 'articles'));
    }
}
