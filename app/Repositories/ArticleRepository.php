<?php
declare(strict_types=1);


namespace App\Repositories;

use App\Models\Article;
use App\Models\Show;
use Illuminate\Database\Eloquent\Collection;

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
     * Get all articles with autors and category
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllArticlesWithAutorsCategory()
    {
        return $this->article::with('users', 'category')->get();
    }

    /**
     * Get article by its ID
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getArticleByID($id)
    {
         return $this->article::findOrFail($id);
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
            ->orderBy('published_at', 'desc')
            ->get();
    }

    /**
     * Get published articles for a show
     *
     * @param Show $show
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPublishedArticleByShow(Show $show): Collection
    {
        return $show->articles()->whereState(1)
            ->get();
    }

    /**
     * Get the article with author and linked objects
     *
     * @param $articleURL
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getArticleByURL($articleURL) {
        return $this->article::with('users', 'shows', 'seasons', 'episodes')
            ->where('article_url', '=', $articleURL)
            ->first();
    }

}