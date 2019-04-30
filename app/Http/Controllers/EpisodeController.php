<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\RateRepository;

use App\Repositories\EpisodeRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\ShowRepository;

use App\Http\Requests\RateRequest;

use App\Traits\FormatShowHeaderTrait;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
/**
 * Class EpisodeController
 * @package App\Http\Controllers
 */
class EpisodeController extends Controller
{
    protected $episodeRepository;
    protected $seasonRepository;
    protected $showRepository;
    protected $commentRepository;
    protected $rateRepository;
    protected $articleRepository;

    use FormatShowHeaderTrait;

    /**
     * EpisodeController constructor.
     * @param EpisodeRepository $episodeRepository
     * @param SeasonRepository $seasonRepository
     * @param ShowRepository $showRepository
     * @param CommentRepository $commentRepository
     * @param RateRepository $rateRepository
     * @param ArticleRepository $articleRepository
     */
    public function __construct(EpisodeRepository $episodeRepository,
                                SeasonRepository $seasonRepository,
                                ShowRepository $showRepository,
                                CommentRepository $commentRepository,
                                RateRepository $rateRepository,
                                ArticleRepository $articleRepository)
    {
        $this->episodeRepository = $episodeRepository;
        $this->seasonRepository = $seasonRepository;
        $this->showRepository = $showRepository;
        $this->commentRepository = $commentRepository;
        $this->rateRepository = $rateRepository;
        $this->articleRepository = $articleRepository;
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

        # Get Show
        $show = $this->showRepository->getShowByURL($showURL);

        if(!is_null($show)) {
            $showInfo = $this->formatForShowHeader($show);

            $seasonInfo = $this->seasonRepository->getSeasonEpisodesBySeasonNameAndShowID($showInfo['show']->id, $seasonName);

            if ($episodeNumero == 0) {
                $episodeInfo = $this->episodeRepository->getEpisodeByEpisodeNumeroSeasonIDAndEpisodeID($seasonInfo->id, $episodeNumero, $episodeID);
            } else {
                $episodeInfo = $this->episodeRepository->getEpisodeByEpisodeNumeroAndSeasonID($seasonInfo->id, $episodeNumero);
            }

            # Compile Object informations
            $object = compileObjectInfos('Episode', $episodeInfo->id);

            $totalEpisodes = $seasonInfo->episodes_count - 1;

            $rates = $this->episodeRepository->getRatesByEpisodeID($episodeInfo->id);
            $rateUser = $this->rateRepository->getRateByUserIDEpisodeID($user_id, $episodeInfo->id);

            # Get Comments
            $comments = $this->commentRepository->getCommentsForFiche($user_id, $object['fq_model'], $object['id']);

            $type_article = 'Season';
            $articles_linked = $this->articleRepository->getPublishedArticleBySeasonID(0, $seasonInfo->id);

            if (Request::ajax()) {
                return Response::json(View::make('comments.last_comments', ['comments' => $comments])->render());
            } else {
                return view('episodes.fiche', compact('showInfo', 'type_article', 'articles_linked', 'seasonInfo', 'episodeInfo', 'totalEpisodes', 'rates', 'comments', 'object', 'rateUser'));
            }
        }else{
            abort(404);
        }
    }
}
