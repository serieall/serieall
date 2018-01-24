<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;

/**
 * Class ArticleController
 * @package App\Http\Controllers
 */
class ArticleController extends Controller
{
    protected $articleRepository;
    protected $categoryRepository;

    /**
     * ArticleController constructor.
     * @param ArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     * @internal param ShowRepository $showRepository
     */
    public function __construct(ArticleRepository $articleRepository,
                                CategoryRepository $categoryRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Print the articles/index vue
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $articles = $this->articleRepository->getPublishedArticlesWithAutorsCommentsAndCategory();

        $categories = $this->categoryRepository->getAllCategories();

        return view('articles.index', compact('articles', 'categories'));
    }

    /**
     * Print the article by its URL
     *
     * @param $articleURL
     * @internal param $id
     * @return \Illuminate\Http\Response
     */
    public function show($articleURL) {
        $article = $this->articleRepository->getArticleByURL($articleURL);

        return response()->view('articles.show', compact('article'));
    }
}