<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\ArticlesListTransformer;
use App\Models\Article;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;


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
     * _limit : add limitation to request result
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        //Retrieve search request and split in array of word
        $this->searchQueryWordArray = explode(" ", Input::get('name-lk'));

        //Refactoring search
        $articles = $this->articles->select('id', 'name')
                ->where(function ($query) {
                    foreach ($this->searchQueryWordArray  as $searchQueryWord){
                        $query->where('name', 'like', '%'.$searchQueryWord.'%');
                    }
                })
                ->orderBy('published_at', 'desc');

        //Limit result, if needed
        if (Input::has('_limit')){
            $limit = intval(Input::get('_limit'));
            if($limit > 0){
                $articles = $articles->limit($limit);
            }
        }

        return $this->response->collection($articles->get(), new ArticlesListTransformer());
    }
}
