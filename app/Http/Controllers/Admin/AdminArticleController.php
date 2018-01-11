<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleCreateRequest;
use App\Models\Article;
use App\Repositories\ArticleRepository;
use Carbon\Carbon;

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

    /**
     * Affiche la page admin/articles/create
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {

        return view('admin/articles/create');
    }

    public function store(ArticleCreateRequest $request) {
        $inputs = $request->all();

        $article = new Article();

        $article->name = $inputs['name'];
        $article->article_url = str_slug($inputs['name']) . '-' . uniqid();
        $article->intro = $inputs['intro'];
        $article->content = $inputs['article'];

        if (isset($inputs['published'])) {
            $article->state = 1;
        }
        if (isset($inputs['une'])) {
            $article->frontpage = 1;
        }

        $article->category()->associate($inputs['category']);

        $article->save();

        dd($inputs);
    }

    public function destroy($id) {
        $article = $this->articleRepository->getArticleByID($id);

        $article->delete();

        return redirect()->back()
            ->with('status_header', 'Suppression')
            ->with('status', 'L\'article a été supprimé.');

    }

}