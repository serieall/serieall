<?php
declare(strict_types=1);

namespace App\Http\Controllers;


use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\ShowRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\EpisodeRepository;

use ConsoleTVs\Charts\Facades\Charts;

/**
 * Class ShowController
 * @package App\Http\Controllers
 */
class ShowController extends Controller
{
    protected $showRepository;
    protected $seasonRepository;
    protected $episodeRepository;
    protected $commentRepository;
    protected $articleRepository;
    protected $categoryRepository;

    /**
     * ShowController constructor.
     * @param ShowRepository $showRepository
     * @param SeasonRepository $seasonRepository
     * @param EpisodeRepository $episodeRepository
     * @param CommentRepository $commentRepository
     * @param ArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(ShowRepository $showRepository,
                                SeasonRepository $seasonRepository,
                                EpisodeRepository $episodeRepository,
                                CommentRepository $commentRepository,
                                ArticleRepository $articleRepository,
                                CategoryRepository $categoryRepository)
    {
        $this->showRepository = $showRepository;
        $this->seasonRepository = $seasonRepository;
        $this->episodeRepository = $episodeRepository;
        $this->commentRepository = $commentRepository;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Print vue shows.index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $shows = $this->showRepository->getAllShows();

        return view('shows.index', compact('shows'));
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

        $type_article = 'Show';
        $articles_linked = $this->articleRepository->getArticleByShowID(0, $showInfo['show']->id);

        return view('shows/fiche', ['chart' => $chart], compact('showInfo', 'type_article','articles_linked', 'comments', 'object'));
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

    public function getShowArticles($show_url) {
        $showInfo = $this->showRepository->getInfoShowFiche($show_url);

        $categories = $this->categoryRepository->getAllCategories();
        $articles = $this->articleRepository->getPublishedArticleByShow($showInfo['show']);
        $articles_count = count($articles);

        return view('articles/fiche', compact('showInfo', 'articles', 'articles_count', 'categories'));
    }

    /**
     * Print the articles/indexCategory vue
     *
     * @param $show_url
     * @param $idCategory
     * @return View
     */
    public function getShowArticlesByCategory($show_url, $idCategory)
    {
        $showInfo = $this->showRepository->getInfoShowFiche($show_url);

        $categories = $this->categoryRepository->getAllCategories();
        $category = $this->categoryRepository->getCategoryByID($idCategory);
        $articles = $this->articleRepository->getPublishedArticlesByCategoriesAndShowWithAutorsCommentsAndCategory($showInfo['show']->id, $idCategory);

        $articles_count = count($articles);

        return view('articles.ficheCategory', compact('showInfo', 'categories', 'category', 'articles', 'articles_count'));
    }
}