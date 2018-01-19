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
     * ArticleController constructor.
     * @param ArticleRepository $articleRepository
     * @internal param ShowRepository $showRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function index() {
        $articles = $this->articleRepository->getPublishedArticlesWithAutorsAndCategory();

        return view('articles.index', compact('articles'));
    }
}