<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\ArtistsTransformer;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use Illuminate\Support\Facades\DB;

/**
 * Class ArtistsController
 * @package App\Http\Controllers\Api\V1
 */
class ArtistsController extends Controller
{
    use Helpers;

    /**
     * @return Response
     */
    public function index() : Response
    {
        $artists = DB::table('artists')->select('name')->orderBy('name');

        $artists = ApiHandler::parseMultiple($artists, ['name'])->getResult();

        return $this->response->collection($artists, new ArtistsTransformer());
    }
}