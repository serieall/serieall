<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Notifications\DatabaseNotification;
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

    /**
     * Create a new controller instance.
     * @param RateRepository $rateRepository
     * @internal param ArticleRepository $articleRepository
     */
    public function __construct(RateRepository $rateRepository, CommentRepository $commentRepository)
    {
        $this->rateRepository = $rateRepository;
        $this->commentRepository = $commentRepository;
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


        return view('pages.home', compact('fil_actu'));
    }
}
