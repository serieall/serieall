<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\CategoriesListTransformer;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Youkoulayley\ApiHandler\ApiHandler;

/**
 * Class CategoriesListController.
 */
class CategoriesListController extends Controller
{
    use Helpers;

    /**
     * @return Response
     */
    public function index()
    {
        $categories = DB::table('categories')->select('id', 'name')->orderBy('name');

        $categories = (new ApiHandler())->parseMultiple($categories, ['id', 'name'])->getResult();

        return $this->response->collection($categories, new CategoriesListTransformer());
    }
}
