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
 * Class ChannelsController
 * @package App\Http\Controllers\Api\V1
 */
class ChannelsController extends Controller
{
    use Helpers;

    /**
     * @return Response
     */
    public function index() : Response
    {
        $channels = DB::table('channels')->select('name')->orderBy('name');

        $channels = ApiHandler::parseMultiple($channels, ['name'])->getResult();

        return $this->response->collection($channels, new ArtistsTransformer());
    }
}