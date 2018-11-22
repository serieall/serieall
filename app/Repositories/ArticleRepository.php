<?php
declare(strict_types=1);


namespace App\Repositories;

use App\Models\Article;
use App\Models\Show;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;

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
        return $this->article::with('users', 'shows', 'seasons', 'episodes', 'category')
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
     * Get all published articles by categories
     *
     * @param Show $show
     * @param $categoryId
     * @return LengthAwarePaginator
     */
    public function getPublishedArticlesByCategoriesAndShowWithAutorsCommentsAndCategory(Show $show, $categoryId): LengthAwarePaginator
    {
        return $show->articles()->with(['users', 'category'])
            ->withCount('comments')
            ->whereState(1)
            ->whereCategoryId($categoryId)
            ->orderBy('published_at', 'desc')
            ->paginate(5);
    }

    /**
     * Get published articles for a show
     *
     * @param Show $show
     * @return LengthAwarePaginator
     */
    public function getPublishedArticleByShow(Show $show): LengthAwarePaginator
    {
        return $show->articles()->whereState(1)
            ->withCount('comments')
            ->orderBy('published_at', 'desc')
            ->paginate(5);
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
            ->where('id', '!=', $article_id)
            ->limit(3)
            ->get();
    }

    /**
     * Return article for a season
     *
     * @param $article_id
     * @param $show_id
     * @return Article[]|Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function getArticleBySeasonID($article_id, $season_id) {
        return $this->article->whereHas('seasons', function ($q) use ($season_id) {
            $q->where('id', '=', $season_id);
        })
            ->where('id', '!=', $article_id)
            ->limit(3)
            ->get();
    }

    /**
     * Return articles similaires
     *
     * @param $article_id
     * @param $category_id
     * @return Article[]|Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function getSimilaryArticles($article_id, $category_id) {
        return $this->article->where('category_id', '=', $category_id)
            ->where('id', '!=', $article_id)
            ->limit(3)
            ->get();
    }

    public function getLast6Articles() {
        return $this->article
            ->where('state', '=', 1)
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();
    }
}