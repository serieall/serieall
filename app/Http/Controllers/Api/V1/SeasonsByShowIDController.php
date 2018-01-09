<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Season;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use App\Http\Transformers\SeasonsListTransformer;


class SeasonsByShowIDController extends Controller
{
    use Helpers;
    protected $seasons;

    public function __construct(Season $season){
        $this->seasons = $season;
    }

    /**
     * @param $showID
     * @return \Dingo\Api\Http\Response
     */
    public function index($showID) : \Dingo\Api\Http\Response
    {
        $seasons = $this->seasons->select('id', 'name')->where('show_id', '=', $showID)->orderBy('name');;

        $seasons = ApiHandler::parseMultiple($seasons, array('name'))->getResult();

        return $this->response->collection($seasons, new SeasonsListTransformer());
    }
}
