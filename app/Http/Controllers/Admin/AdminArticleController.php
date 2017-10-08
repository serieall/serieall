<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;

class AdminArticleController extends Controller
{

    protected $articleRepository;

    /**
     * AdminArticleController constructor.
     *
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository) {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Affiche la page admin/articles/index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $articles = $this->articleRepository->getAllArticlesWithAutorsCategory();

        return view('admin/articles/index', compact('articles'));
    }

}