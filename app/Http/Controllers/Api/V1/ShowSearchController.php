<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\ShowSearchTransformer;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
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
        //Get search request
        $searchQuery = Input::get('_q');

        //Perform search on name/name fr
        $shows = DB::table('shows')
            ->select('id', 'show_url', 'name', 'name_fr')
            ->where('name','like', '%'.$searchQuery.'%')
            ->orWhere('name_fr','like', '%'.$searchQuery.'%')
            ->orderBy('name');


        return $this->response->collection($shows->get(), new ShowSearchTransformer());

    }
}