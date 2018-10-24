<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\ArticlesListTransformer;
use App\Models\Article;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;


/**
 * Class ShowsListController
 * @package App\Http\Controllers\Api\V1
 */
class ArticlesListController extends Controller
{
    use Helpers;
    protected $shows;

    /**
     * ShowsListController constructor.
     * @param Article $article
     */
    public function __construct(Article $article){
        $this->articles = $article;
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $articles = $this->articles->select('id', 'name')
        ->orderBy('published_at', 'desc');

        $articles = ApiHandler::parseMultiple($articles, ['name'])->getResult();

        return $this->response->collection($articles, new ArticlesListTransformer());
    }
}
