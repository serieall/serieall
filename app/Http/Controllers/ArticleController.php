<?php

namespace App\Http\Controllers;

use App\Models\Season;

use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\ShowRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\EpisodeRepository;

use ConsoleTVs\Charts\Facades\Charts;

class ArticleController extends Controller
{
    protected $articleRepository;

    /**
     * ShowController constructor.
     * @param ArticleRepository $articleRepository
     * @internal param ShowRepository $showRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function index() {
        $articles = $this->articleRepository->getAllArticlesWithAutorsCategory();

        return view('articles.index', compact('articles'));
    }

    /**
     * Envoi vers la page shows/index
     *
     * @param $show_url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShowFiche($show_url)
    {
        # Get ID User if user authenticated
        $user_id = getIDIfAuth();

        # Get Show
        $showInfo = $this->showRepository->getInfoShowFiche($show_url);

        # Generate Chart
        $chart = Charts::create('area', 'highcharts')
            ->title('Evolution des notes de la série')
            ->elementLabel('Notes')
            ->xAxisTitle('Numéro de la saison')
            ->labels($showInfo['seasons']->pluck('name'))
            ->values($showInfo['seasons']->pluck('moyenne'))
            ->dimensions(0, 300);

        # Compile Object informations
        $object = compileObjectInfos('Show', $showInfo['show']->id);

        # Get Comments
        $comments = $this->commentRepository->getCommentsForFiche($user_id, $object['fq_model'], $object['id']);

        return view('shows/fiche', ['chart' => $chart], compact('showInfo', 'comments', 'object'));
    }

    /**
     * Envoi vers la page shows/details
     *
     * @param $show_url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShowDetails($show_url) {
        $showInfo = $this->showRepository->getInfoShowFiche($show_url);

        return view('shows/details', compact('showInfo', 'genres'));
    }
}