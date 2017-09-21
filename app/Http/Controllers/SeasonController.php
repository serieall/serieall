<?php

namespace App\Http\Controllers;


use App\Models\Season;

use App\Repositories\CommentRepository;
use App\Repositories\ShowRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\EpisodeRepository;

use Illuminate\Support\Facades\Auth;

class SeasonController extends Controller
{
    protected $showRepository;
    protected $seasonRepository;
    protected $commentRepository;

    /**
     * ShowController constructor.
     * @param ShowRepository $showRepository
     * @param SeasonRepository $seasonRepository
     * @param CommentRepository $commentRepository
     */
    public function __construct(ShowRepository $showRepository,
                                SeasonRepository $seasonRepository,
                                CommentRepository $commentRepository)
    {
        $this->showRepository = $showRepository;
        $this->seasonRepository = $seasonRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * Envoi vers la page shows/seasons
     *
     * @param $show_url
     * @param $season
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSeasonFiche($show_url, $season) {
        # Get ID User if user authenticated
        $user_id = getIDIfAuth();

        $showInfo = $this->showRepository->getInfoShowFiche($show_url);
        $seasonInfo = $this->seasonRepository->getSeasonEpisodesBySeasonNameAndShowID($showInfo['show']->id, $season);

        # Compile Object informations
        $object = compileObjectInfos('Season', $seasonInfo->id);

        $ratesSeason = Season::with(['users' => function($q){
               $q->orderBy('updated_at', 'desc');
               $q->limit(20);
            }, 'users.episode' => function($q){
                $q->select('id', 'numero');
            }, 'users.user' => function($q){
                $q->select('id', 'username', 'email');
            }])
            ->where('id', '=', $seasonInfo->id)
            ->first()
            ->toArray();

        # Get Comments
        $comments = $this->commentRepository->getCommentsForFiche($user_id, $object['fq_model'], $object['id']);

        return view('seasons.fiche', compact('showInfo', 'seasonInfo', 'ratesSeason', 'comments', 'object'));
    }
}