<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Models\Season;
use App\Repositories\ShowRepository;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use App\Http\Transformers\SeasonsListTransformer;


/**
 * Class SeasonsByShowIDController
 * @property ShowRepository showRepository
 * @package App\Http\Controllers\Api\V1
 */
class SeasonsByShowNameController extends Controller
{
    use Helpers;
    protected $season;

    /**
     * SeasonsByShowIDController constructor.
     * @param Season $season
     * @param ShowRepository $showRepository
     */
    public function __construct(Season $season,
                                ShowRepository $showRepository){
        $this->season = $season;
        $this->showRepository = $showRepository;
    }

    /**
     * @param $show_name
     * @return \Dingo\Api\Http\Response
     */
    public function index($show_name) : Response
    {
        $show = $this->showRepository->getByName($show_name);
        $seasons = $this->season::select('name', 'id')->where('show_id', '=', $show->id);

        $seasons = ApiHandler::parseMultiple($seasons, ['name'])->getResult();

        return $this->response->collection($seasons, new SeasonsListTransformer());
    }
}
