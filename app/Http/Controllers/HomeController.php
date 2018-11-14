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
        $lastRates = $this->rateRepository->getLast20Rates();
        foreach ($lastRates as $rate) {
            $rate->type = "rate";
        }
        $lastComments = $this->commentRepository->getLast20Comments();
        foreach ($lastComments as $comment) {
            $comment->type = "comment";
        }

        # Fusion des deux collections pour avoir
        $fil_actu = $lastRates->merge($lastComments)->sortByDesc('created_at');
        return view('pages.home', compact('fil_actu'));
    }
}
