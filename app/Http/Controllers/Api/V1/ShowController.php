<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\ShowTransformer;
use App\Models\Show;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{
    use Helpers;

    public function index() : Response
    {
        $shows = DB::table('shows')->select('name', 'show_url');

        $shows = ApiHandler::parseMultiple($shows, array('name', 'show_url'))->getResult();

        return $this->response->collection($shows, new ShowTransformer);
    }
}