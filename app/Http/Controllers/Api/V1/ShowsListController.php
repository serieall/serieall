<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Show;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use App\Http\Transformers\ShowsListTransformer;


class ShowsListController extends Controller
{
    use Helpers;
    protected $shows;

    public function __construct(Show $show){
        $this->shows = $show;
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function index() : \Dingo\Api\Http\Response
    {
        $shows = $this->shows->with(['genres' => function ($q){
            $q->select('name');
        }])
        ->select('id', 'name', 'name_fr');

        $shows = ApiHandler::parseMultiple($shows, array('name', 'name_fr'))->getResult();

        return $this->response->collection($shows, new ShowsListTransformer());
    }
}
