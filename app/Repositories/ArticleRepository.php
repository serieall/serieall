<?php
declare(strict_types=1);


namespace App\Repositories;

use App\Models\Article;
use App\Models\Show;

/**
 * Class ArticleRepository
 * @package App\Repositories
 */
class ArticleRepository
{
    protected $article;

    /**
     * ArticleRepository constructor.
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Get all articles with autorsand category
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllArticlesWithAutorsCategory() {
        return $this->article::with('users', 'category')->get();
    }

    /**
     * Get article by its ID
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|static
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getArticleByID($id)
    {
        return $this->article::firstOrFail($id);
    }

    /**
     * Get all published articles in une
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getArticlesUne()
    {
        return $this->article::with('users')->whereFrontpage(1)->whereState(1)->orderBy('published_at')->get();
    }

    /**
     * Get all published articles
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getPublishedArticlesWithAutorsAndCategory()
    {
        return $this->article::with('users', 'category')
            ->whereState(1)
            ->orderBy('published_at')
            ->get();
    }

    /**
     * Get published articles for a show
     *
     * @param Show $show
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPublishedArticleByShow(Show $show) {
        return $show->articles()->whereState(1)
            ->get();
    }
}