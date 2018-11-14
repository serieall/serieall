<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\View;
use Torann\PodcastFeed\Facades\PodcastFeed;


/**
 * Class ArticleController
 * @package App\Http\Controllers
 */
class ArticleController extends Controller
{
    protected $articleRepository;
    protected $categoryRepository;
    protected $commentRepository;

    /**
     * ArticleController constructor.
     * @param ArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     * @param CommentRepository $commentRepository
     * @internal param ShowRepository $showRepository
     */
    public function __construct(ArticleRepository $articleRepository,
                                CategoryRepository $categoryRepository,
                                CommentRepository  $commentRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * Print the articles/index vue
     *
     * @return View
     */
    public function index()
    {
        $articles = $this->articleRepository->getPublishedArticlesWithAutorsCommentsAndCategory();
        $articles_count = count($articles);
        $categories = $this->categoryRepository->getAllCategories();

        return view('articles.index', compact('articles', 'articles_count', 'categories'));
    }

    /**
     * Print the articles/indexCategory vue
     *
     * @param $idCategory
     * @return View
     */
    public function indexByCategory($idCategory)
    {
        $categories = $this->categoryRepository->getAllCategories();
        $category = $this->categoryRepository->getCategoryByID($idCategory);
        $articles = $this->articleRepository->getPublishedArticlesByCategoriesWithAutorsCommentsAndCategory($idCategory);

        $articles_count = count($articles);

        return view('articles.indexCategory', compact('categories', 'category', 'articles', 'articles_count'));
    }

    /**
     * Print the article by its URL
     *
     * @param $articleURL
     * @internal param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($articleURL) {
        $user_id = getIDIfAuth();
        $article = $this->articleRepository->getArticleByURL($articleURL);
        $object = compileObjectInfos('Article', $article->id);
        $comments = $this->commentRepository->getCommentsForFiche($user_id, $object['fq_model'], $object['id']);

        if($article->shows_count == 1) {
            if($article->seasons_count >= 1) {
                $type_article = "Season";
                if ($article->episodes_count >=1) {
                    foreach($article->seasons as $season) {
                        $articles_linked = $this->articleRepository->getArticleBySeasonID($article->id, $season->id);
                    }
                } else {
                    foreach($article->seasons as $season) {
                        $articles_linked = $this->articleRepository->getArticleBySeasonID($article->id, $season->id);
                    }
                }
            }
            else {
                // C'est un article sur une série
                $type_article = "Show";
                foreach($article->shows as $show) {
                    $articles_linked = $this->articleRepository->getArticleByShowID($article->id, $show->id);
                }
            }
        } else {
            $type_article = "";
            $articles_linked = $this->articleRepository->getSimilaryArticles($article->id, $article->category_id);
        }

        if (Request::ajax()) {
            return Response::json(View::make('comments.comment_article', ['comments' => $comments])->render());
        }
        else {
            return view('articles.show', compact('article', 'comments', 'object', 'type_article', 'articles_linked'));
        }
    }

    public function RSSPodcast() {
        $podcasts = Article::where('podcast', '=', true)->get();

        foreach($podcasts as $podcast) {
            PodcastFeed::addMedia([
                'title'       => $podcast->name,
                'description' => $podcast->intro,
                'publish_at'  => $podcast->published_at,
                'guid'        => route('article.show', $podcast->article_url),
                'url'         => "https://serieall.fr/podcasts/Retro2.mp3",
                'type'        => $podcast->media_content_type,
                'duration'    => "30:00",
                'image'       => "https://journeytotheit.ovh" . $podcast->image,
            ]);
        }

        return Response::make(PodcastFeed::toString())
            ->header('Content-Type', 'text/xml');
    }
}