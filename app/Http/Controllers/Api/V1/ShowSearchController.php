<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\ShowSearchTransformer;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use Illuminate\Support\Facades\DB;

/**
 * Class ShowSearchController
 * @package App\Http\Controllers\Api\V1
 */
class ShowSearchController extends Controller
{
    use Helpers;

    /**
     * @return Response
     */
    public function index() : Response
    {
        $shows = DB::table('shows')->select('id', 'show_url', 'name', 'name_fr')->orderBy('name');

        $shows = ApiHandler::parseMultiple($shows, ['name', 'name_fr'])->getResult();

        return $this->response->collection($shows, new ShowSearchTransformer());
    }
}