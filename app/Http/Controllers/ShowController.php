<?php

namespace App\Http\Controllers;


use App\Models\Season;

use App\Repositories\CommentRepository;
use App\Repositories\ShowRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\EpisodeRepository;

use Illuminate\Support\Facades\Auth;

class ShowController extends Controller
{
    protected $showRepository;
    protected $seasonRepository;
    protected $episodeRepository;
    protected $commentRepository;

    /**
     * ShowController constructor.
     * @param ShowRepository $showRepository
     * @param SeasonRepository $seasonRepository
     * @param EpisodeRepository $episodeRepository
     * @param CommentRepository $commentRepository
     */
    public function __construct(ShowRepository $showRepository,
                                SeasonRepository $seasonRepository,
                                EpisodeRepository $episodeRepository,
                                CommentRepository $commentRepository)
    {
        $this->showRepository = $showRepository;
        $this->seasonRepository = $seasonRepository;
        $this->episodeRepository = $episodeRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * Envoi vers la page shows/index
     *
     * @param $show_url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShow($show_url)
    {
        # Define variables
        if(Auth::check()) {
            $user_id = Auth::user()->id;
        }
        else {
            $user_id = null;
        }

        $type = 'App\Models\Show';

        # Get Show
        $showInfo = $this->showRepository->getInfoShowFiche($show_url);
        $show_id = $showInfo['show']->id;

        # Get Comments
        $comments = getComments($user_id, $type, $show_id);

        return view('shows/index', compact('showInfo', 'comments'));
    }

    /**
     * Envoi vers la page shows/details
     *
     * @param $show_url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShowDetails($show_url) {
        $showInfo = $this->showRepository->getInfoShowFiche($show_url);

        return view('shows/details', compact('showInfo'));
    }

    /**
     * Envoi vers la page shows/seasons
     *
     * @param $show_url
     * @param $season
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShowSeasons($show_url, $season) {
        $showInfo = $this->showRepository->getInfoShowFiche($show_url);
        $seasonInfo = $this->seasonRepository->getSeasonEpisodesBySeasonNameAndShowID($showInfo['show']->id, $season);

        $ratesSeason = Season::with(['users' => function($q){
               $q->orderBy('updated_at', 'desc');
            }, 'users.episode' => function($q){
                $q->select('id', 'numero');
            }, 'users.user' => function($q){
                $q->select('id', 'username', 'email');
            }])
            ->where('id', '=', $seasonInfo->id)
            ->first()
            ->toArray();

        return view('shows.seasons', compact('showInfo', 'seasonInfo', 'ratesSeason'));
    }

    /**
     * Envoi vers la page shows/episodes
     *
     * @param $showURL
     * @param $seasonName
     * @param $episodeNumero
     * @param null $episodeID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShowEpisodes($showURL, $seasonName, $episodeNumero, $episodeID = null)
    {
        $showInfo = $this->showRepository->getInfoShowFiche($showURL);
        $seasonInfo = $this->seasonRepository->getSeasonEpisodesBySeasonNameAndShowID($showInfo['show']->id, $seasonName);

        if($episodeNumero == 0) {
            $episodeInfo = $this->episodeRepository->getEpisodeByEpisodeNumeroSeasonIDAndEpisodeID($seasonInfo->id, $episodeNumero, $episodeID);
        }
        else {
            $episodeInfo = $this->episodeRepository->getEpisodeByEpisodeNumeroAndSeasonID($seasonInfo->id, $episodeNumero);
        }

        $totalEpisodes = $seasonInfo->episodes_count - 1;

        $rates = $this->episodeRepository->getRatesByEpisodeID($episodeInfo->id);

        return view('shows.episodes', compact('showInfo', 'seasonInfo', 'episodeInfo', 'totalEpisodes', 'rates'));
    }
}