<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\GenresTransformer;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use Illuminate\Support\Facades\DB;

class GenresController extends Controller
{
    use Helpers;

    public function index() : Response
    {
        $genres = DB::table('genres')->select('name')->orderBy('name');

        $genres = ApiHandler::parseMultiple($genres, array('name'))->getResult();

        return $this->response->collection($genres, new GenresTransformer());
    }
}