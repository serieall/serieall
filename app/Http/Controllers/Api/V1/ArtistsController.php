<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\ArtistsTransformer;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use Illuminate\Support\Facades\DB;

class ArtistsController extends Controller
{
    use Helpers;

    public function index() : Response
    {
        $artists = DB::table('artists')->select('name')->orderBy('name');

        $artists = ApiHandler::parseMultiple($artists, array('name'))->getResult();

        return $this->response->collection($artists, new ArtistsTransformer());
    }
}