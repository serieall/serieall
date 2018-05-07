<?php
declare(strict_types=1);


namespace App\Repositories;

use App\Models\Article;
use App\Models\Show;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
     * Get the article with author and linked objects by its ID
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getArticleWithAllInformationsByID($id) {
        return $this->article::with('users', 'shows', 'seasons', 'episodes')
            ->whereId($id)
            ->first();
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
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPublishedArticlesWithAutorsCommentsAndCategory(): LengthAwarePaginator
    {
        return $this->article::with('users', 'category')
            ->withCount('comments')
            ->whereState(1)
            ->orderBy('published_at', 'desc')
            ->paginate(10);
    }

    /**
     * Get all published articles by categories
     *
     * @param $categoryId
     * @return LengthAwarePaginator
     */
    public function getPublishedArticlesByCategoriesWithAutorsCommentsAndCategory($categoryId): LengthAwarePaginator
    {
        return $this->article::with('users', 'category')
            ->withCount('comments')
            ->whereState(1)
            ->whereCategoryId($categoryId)
            ->orderBy('published_at', 'desc')
            ->paginate(10);
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
            ->withCount('users', 'shows', 'seasons', 'episodes')
            ->where('article_url', '=', $articleURL)
            ->first();
    }

    /**
     * Return article for a show
     *
     * @param $article_id
     * @param $show_id
     * @return Article[]|Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function getArticleByShowID($article_id, $show_id) {
        return $this->article->whereHas('shows', function ($q) use ($show_id) {
            $q->where('id', '=', $show_id);
        })
            ->get();
    }

}