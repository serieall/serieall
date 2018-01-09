<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Season;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use App\Http\Transformers\SeasonsListTransformer;


class SeasonsListController extends Controller
{
    use Helpers;
    protected $seasons;

    public function __construct(Season $season){
        $this->seasons = $season;
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function index() : \Dingo\Api\Http\Response
    {
        $seasons = $this->seasons->select('id', 'name', 'show_id');

        $seasons = ApiHandler::parseMultiple($seasons, array('name', 'show_id'))->getResult();

        return $this->response->collection($seasons, new SeasonsListTransformer());
    }
}
