<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Models\Season;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use App\Http\Transformers\SeasonsListTransformer;


/**
 * Class SeasonsByShowIDController
 * @package App\Http\Controllers\Api\V1
 */
class SeasonsByShowIDController extends Controller
{
    use Helpers;
    protected $seasons;

    /**
     * SeasonsByShowIDController constructor.
     * @param Season $season
     */
    public function __construct(Season $season){
        $this->seasons = $season;
    }

    /**
     * @param $showID
     * @return Response
     */
    public function index($showID) : Response
    {
        $seasons = $this->seasons::select('id', 'name')::where('show_id', '=', $showID)::orderBy('name');

        $seasons = ApiHandler::parseMultiple($seasons, ['name'])->getResult();

        return $this->response->collection($seasons, new SeasonsListTransformer());
    }
}
