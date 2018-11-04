<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\EpisodeRepository;
use App\Repositories\RateRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\ShowRepository;


/**
 * Class ArticleController
 * @package App\Http\Controllers
 */
class ClassementController extends Controller
{
    protected $showRepository;
    protected $seasonRepository;
    protected $episodeRepository;
    protected $rateRepository;

    /**
     * ClassementController constructor.
     * @param ShowRepository $showRepository
     * @param SeasonRepository $seasonRepository
     * @param EpisodeRepository $episodeRepository
     * @param RateRepository $rateRepository
     */
    public function __construct(ShowRepository $showRepository,
                                SeasonRepository $seasonRepository,
                                EpisodeRepository $episodeRepository,
                                RateRepository $rateRepository)
    {
        $this->showRepository = $showRepository;
        $this->seasonRepository = $seasonRepository;
        $this->episodeRepository = $episodeRepository;
        $this->rateRepository = $rateRepository;
    }

    /**
     * Return the view classements.index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        # Top Show
        $top_shows = $this->showRepository->getRankingShows('DESC');
        $flop_shows = $this->showRepository->getRankingShows('ASC');
        $top_seasons = $this->seasonRepository->getRankingSeasons('DESC');
        $flop_seasons = $this->seasonRepository->getRankingSeasons('ASC');
        $top_episodes = $this->episodeRepository->getRankingEpisodes('DESC');
        $flop_episodes = $this->episodeRepository->getRankingEpisodes('ASC');

        # Redac
        $redac_top_shows = $this->rateRepository->getRankingShowRedac('DESC');
        $redac_flop_shows = $this->rateRepository->getRankingShowRedac('ASC');

        return view('classements.index', compact('top_shows', 'flop_shows', 'top_seasons', 'flop_seasons', 'top_episodes', 'flop_episodes', 'redac_top_shows', 'redac_flop_shows'));
    }
}