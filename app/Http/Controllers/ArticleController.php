<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;

/**
 * Class ArticleController
 * @package App\Http\Controllers
 */
class ArticleController extends Controller
{
    protected $articleRepository;

    /**
     * ArticleController constructor.
     * @param ArticleRepository $articleRepository
     * @internal param ShowRepository $showRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Print the articles/index vue
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $articles = $this->articleRepository->getPublishedArticlesWithAutorsAndCategory();

        return view('articles.index', compact('articles'));
    }
}