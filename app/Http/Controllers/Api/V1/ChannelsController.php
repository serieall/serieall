<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\ArtistsTransformer;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use Illuminate\Support\Facades\DB;

class ChannelsController extends Controller
{
    use Helpers;

    public function index() : Response
    {
        $channels = DB::table('channels')->select('name')->orderBy('name');

        $channels = ApiHandler::parseMultiple($channels, array('name'))->getResult();

        return $this->response->collection($channels, new ArtistsTransformer());
    }
}