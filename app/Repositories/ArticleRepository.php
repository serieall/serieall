<?php


namespace App\Repositories;

use App\Models\Article;

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
     * Récupère un article en fonction de son ID
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function getArticleByID($id)
    {
        return $this->article->firstOrFail($id);
    }

    /**
     * Get all published articles in une
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getArticlesUne()
    {
        return $this->article->with('users')->whereFrontpage(1)->whereState(1)->orderBy('published_at')->get();
    }

    /**
     * Get all published articles
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getPublishedArticlesWithAutorsAndCategory()
    {
        return $this->article
            ->with('users', 'category')
            ->whereState(1)
            ->orderBy('published_at')
            ->get();
    }
}