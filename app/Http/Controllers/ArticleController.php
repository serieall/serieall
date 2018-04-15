<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use Illuminate\View\View;


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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() : View
    {
        $articles = $this->articleRepository->getPublishedArticlesWithAutorsCommentsAndCategory();

        $categories = $this->categoryRepository->getAllCategories();

        return view('articles.index', compact('articles', 'categories'));
    }

    /**
     * Print the articles/indexCategory vue
     *
     * @param $idCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexByCategory($idCategory) : View
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

        if (Request::ajax()) {
            return Response::json(View::make('comments.comment_article', ['comments' => $comments])->render());
        }
        else {
            return view('articles.show', compact('article', 'comments', 'object'));
        }

    }
}