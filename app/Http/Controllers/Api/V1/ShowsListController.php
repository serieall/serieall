<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Models\Show;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use App\Http\Transformers\ShowsListTransformer;


/**
 * Class ShowsListController
 * @package App\Http\Controllers\Api\V1
 */
class ShowsListController extends Controller
{
    use Helpers;
    protected $shows;

    /**
     * ShowsListController constructor.
     * @param Show $show
     */
    public function __construct(Show $show){
        $this->shows = $show;
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function index() : Response
    {
        $shows = $this->shows::with(['genres' => function ($q){
            $q->select('name');
        }])
        ->select('id', 'name', 'name_fr')
        ->orderBy('name');

        $shows = ApiHandler::parseMultiple($shows, ['name', 'name_fr'])->getResult();

        return $this->response->collection($shows, new ShowsListTransformer());
    }
}
