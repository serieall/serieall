<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\NationalitiesTransformer;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use Illuminate\Support\Facades\DB;

class NationalitiesController extends Controller
{
    use Helpers;

    public function index() : Response
    {
        $nationalities = DB::table('nationalities')->select('name')->orderBy('name');

        $nationalities = ApiHandler::parseMultiple($nationalities, array('name'))->getResult();

        return $this->response->collection($nationalities, new NationalitiesTransformer());
    }
}