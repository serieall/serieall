<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Models\Season;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use App\Http\Transformers\SeasonsListTransformer;


/**
 * Class SeasonsListController
 * @package App\Http\Controllers\Api\V1
 */
class SeasonsListController extends Controller
{
    use Helpers;
    protected $seasons;

    /**
     * SeasonsListController constructor.
     * @param Season $season
     */
    public function __construct(Season $season){
        $this->seasons = $season;
    }

    /**
     * @return Response
     */
    public function index() : Response
    {
        $seasons = $this->seasons::select('id', 'name', 'show_id');

        $seasons = ApiHandler::parseMultiple($seasons, ['name', 'show_id'])->getResult();

        return $this->response->collection($seasons, new SeasonsListTransformer());
    }
}
