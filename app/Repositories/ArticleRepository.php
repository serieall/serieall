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

    public function getArticleByID($id) {
        return $this->article->firstOrFail($id);
    }

}