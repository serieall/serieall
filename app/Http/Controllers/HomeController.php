<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Notifications\DatabaseNotification;
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

    /**
     * Create a new controller instance.
     * @param RateRepository $rateRepository
     * @internal param ArticleRepository $articleRepository
     */
    public function __construct(RateRepository $rateRepository)
    {
        $this->rateRepository = $rateRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lastRates = $this->rateRepository->getLast20Rates();

        return view('pages.home', compact('lastRates'));
    }
}
