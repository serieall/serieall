<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;
use App\Repositories\RateRepository;
use GuzzleHttp\Client;

use App\Repositories\EpisodeRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\ShowRepository;

use App\Http\Requests\RateRequest;

use App\Models\Episode;
use App\Models\Episode_user;
use App\Models\Season;

class EpisodeController extends Controller
{
    protected $episodeRepository;
    protected $seasonRepository;
    protected $showRepository;
    protected $commentRepository;
    protected $rateRepository;

    /**
     * EpisodeController constructor.
     * @param EpisodeRepository $episodeRepository
     * @param SeasonRepository $seasonRepository
     * @param ShowRepository $showRepository
     * @param CommentRepository $commentRepository
     * @param RateRepository $rateRepository
     */
    public function __construct(EpisodeRepository $episodeRepository,
                                SeasonRepository $seasonRepository,
                                ShowRepository $showRepository,
                                CommentRepository $commentRepository,
                                RateRepository $rateRepository)
    {
        $this->episodeRepository = $episodeRepository;
        $this->seasonRepository = $seasonRepository;
        $this->showRepository = $showRepository;
        $this->commentRepository = $commentRepository;
        $this->rateRepository = $rateRepository;
    }

    /**
     * Notation d'un épisode
     * Mise à jour de le moyenne des épisodes/saisons/séries
     * Mise à jour du nombre de notes épisodes/saisons/séries
     *
     * @param RateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rateEpisode(RateRequest $request)
    {
        // Définition des variables
        $user_id = $request->user()->id;

        $this->rateRepository->RateEpisode($user_id, $request->episode_id, $request->note);

        return response()->json();
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
    public function getEpisodeFiche($showURL, $seasonName, $episodeNumero, $episodeID = null)
    {
        # Get ID User if user authenticated
        $user_id = getIDIfAuth();

        $showInfo = $this->showRepository->getInfoShowFiche($showURL);
        $seasonInfo = $this->seasonRepository->getSeasonEpisodesBySeasonNameAndShowID($showInfo['show']->id, $seasonName);

        if($episodeNumero == 0) {
            $episodeInfo = $this->episodeRepository->getEpisodeByEpisodeNumeroSeasonIDAndEpisodeID($seasonInfo->id, $episodeNumero, $episodeID);
        }
        else {
            $episodeInfo = $this->episodeRepository->getEpisodeByEpisodeNumeroAndSeasonID($seasonInfo->id, $episodeNumero);
        }

        # Compile Object informations
        $object = compileObjectInfos('Episode', $episodeInfo->id);

        $totalEpisodes = $seasonInfo->episodes_count - 1;

        $rates = $this->episodeRepository->getRatesByEpisodeID($episodeInfo->id);
        $rateUser = $this->rateRepository->getRateByUserIDEpisodeID($user_id, $episodeInfo->id);

        # Get Comments
        $comments = $this->commentRepository->getCommentsForFiche($user_id, $object['fq_model'], $object['id']);

        return view('episodes.fiche', compact('showInfo', 'seasonInfo', 'episodeInfo', 'totalEpisodes', 'rates', 'comments', 'object', 'rateUser'));
    }
}
