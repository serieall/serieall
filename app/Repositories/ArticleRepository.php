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
    public function __construct(Article $article) {
        $this->article = $article;
    }

    /**
     * Récupère tous les articles
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllArticlesWithAutorsCategory() {
        return $this->article->with('users', 'category')->get();
    }

    /**
     * Récupère un article en fonction de son ID
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function getArticleByID($id) {
        return $this->article->firstOrFail($id);
    }

    public function getArticleUne() {
        dd($this->article->with('users')->limit(3)->orderBy('published_at')->get());
    }

}