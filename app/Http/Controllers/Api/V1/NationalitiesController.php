<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\NationalitiesTransformer;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Youkoulayley\ApiHandler\Facades\ApiHandler;

/**
 * Class NationalitiesController.
 */
class NationalitiesController extends Controller
{
    use Helpers;

    public function index(): Response
    {
        $nationalities = DB::table('nationalities')->select('name')->orderBy('name');

        $nationalities = ApiHandler::parseMultiple($nationalities, ['name'])->getResult();

        return $this->response->collection($nationalities, new NationalitiesTransformer());
    }
}
