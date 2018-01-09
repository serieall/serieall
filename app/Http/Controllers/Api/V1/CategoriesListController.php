<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\CategoriesListTransformer;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use Illuminate\Support\Facades\DB;

class CategoriesListController extends Controller
{
    use Helpers;

    public function index() : Response
    {
        $categories = DB::table('categories')->select('id', 'name')->orderBy('name');

        $categories = ApiHandler::parseMultiple($categories, array('id', 'name'))->getResult();

        return $this->response->collection($categories, new CategoriesListTransformer());
    }
}