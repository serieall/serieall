<?php
declare(strict_types=1);

namespace App\Http\Controllers;


use App\Charts\RateSummary;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\ShowRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\EpisodeRepository;

use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index() {
        if(Request::ajax()) {
            $shows = $this->showRepository->getAllShows();
            return Response::json(View::make('shows.index_cards', ['shows' => $shows])->render());
        } else {
            $shows = $this->showRepository->getAllShows();
        }

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

        $state_show = "";
        if(Auth::check()) {
            if(Auth::user()->shows->contains($showInfo['show']->id)) {
                $state_show = Auth::user()->join('show_user', 'users.id', '=', 'show_user.user_id')
                    ->join('shows', 'show_user.show_id', '=', 'shows.id')
                    ->where('users.id', '=', Auth::user()->id)
                    ->where('shows.id', '=', $showInfo['show']->id)
                    ->pluck('state')
                    ->first();
            }
        }

        $chart = new RateSummary;
        $chart
            ->height(300)
            ->title('Evolution des notes de la série')
            ->labels($showInfo['seasons']->pluck('name'))
            ->dataset('Moyenne', 'line', $showInfo['seasons']->pluck('moyenne'));

        # Compile Object informations
        $object = compileObjectInfos('Show', $showInfo['show']->id);

        # Get Comments
        $comments = $this->commentRepository->getCommentsForFiche($user_id, $object['fq_model'], $object['id']);

        $type_article = 'Show';
        $articles_linked = $this->articleRepository->getArticleByShowID(0, $showInfo['show']->id);

        return view('shows/fiche', ['chart' => $chart], compact('showInfo', 'type_article','articles_linked', 'comments', 'object', 'state_show'));
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

        return view('shows/articles', compact('showInfo', 'articles', 'articles_count', 'categories'));
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
        $articles = $this->articleRepository->getPublishedArticlesByCategoriesAndShowWithAutorsCommentsAndCategory($showInfo['show'], $idCategory);

        $articles_count = count($articles);

        return view('shows.articlesCategory', compact('showInfo', 'categories', 'category', 'articles', 'articles_count', 'idCategory'));
    }

    /**
     * Get Statistics. Return shows.statistics
     *
     * @param $show_url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getStatistics($show_url) {
        $showInfo = $this->showRepository->getInfoShowFiche($show_url);
        $topEpisodes = $this->episodeRepository->getRankingEpisodesByShow($showInfo['show']['id'], 'DESC');

        return view('shows.statistics', compact('showInfo', 'topEpisodes'));
    }
}