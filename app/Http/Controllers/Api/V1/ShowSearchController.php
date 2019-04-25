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

    // List of words contains in request
    private $searchQueryWordArray;

    /**
     * @return Response
     */
    public function index() : Response
    {
        if(!is_null(Input::get('_q')) ) {
            //Retrieve search request and split in array of word
            $this->searchQueryWordArray = explode(" ", Input::get('_q'));


            //Perform search on name/name fr
            //each word typed in tested, only shows whose match all are returned
            $shows = DB::table('shows')
                ->select('id', 'show_url', 'name', 'name_fr')
                ->where(function ($query) {
                    foreach ($this->searchQueryWordArray as $searchQueryWord) {
                        $query->where('name', 'like', '%' . $searchQueryWord . '%');
                    }
                })
                ->orWhere(function ($query) {
                    foreach ($this->searchQueryWordArray as $searchQueryWord) {
                        $query->where('name_fr', 'like', '%' . $searchQueryWord . '%');
                    }
                })
                ->orderBy('name');


            return $this->response->collection($shows->get(), new ShowSearchTransformer());
        }else{
            $this->response->errorBadRequest("Missing parameter _q");
        }

    }
}