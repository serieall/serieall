<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\CategoriesListTransformer;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use Illuminate\Support\Facades\DB;

/**
 * Class CategoriesListController
 * @package App\Http\Controllers\Api\V1
 */
class CategoriesListController extends Controller
{
    use Helpers;

    /**
     * @return Response
     */
    public function index() : Response
    {
        $categories = DB::table('categories')->select('id', 'name')->orderBy('name');

        $categories = ApiHandler::parseMultiple($categories, ['id', 'name'])->getResult();

        return $this->response->collection($categories, new CategoriesListTransformer());
    }
}