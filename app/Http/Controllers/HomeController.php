<?php

namespace App\Http\Controllers;


use App\Repositories\ArticleRepository;

class HomeController extends Controller
{

    protected $articleRepository;

    /**
     * Create a new controller instance.
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->middleware('auth');
        $this->articleRepository = $articleRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articlesUne = $this->articleRepository->getArticleUne();

        return view('pages.home', compact('articlesUne'));
    }
}
