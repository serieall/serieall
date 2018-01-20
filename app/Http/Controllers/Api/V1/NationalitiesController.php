<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\NationalitiesTransformer;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use Illuminate\Support\Facades\DB;

/**
 * Class NationalitiesController
 * @package App\Http\Controllers\Api\V1
 */
class NationalitiesController extends Controller
{
    use Helpers;

    /**
     * @return Response
     */
    public function index() : Response
    {
        $nationalities = DB::table('nationalities')->select('name')->orderBy('name');

        $nationalities = ApiHandler::parseMultiple($nationalities, ['name'])->getResult();

        return $this->response->collection($nationalities, new NationalitiesTransformer());
    }
}