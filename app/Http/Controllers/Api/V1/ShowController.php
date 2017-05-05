<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\ShowTransformer;
use App\Models\Show;
use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use JohannesSchobel\DingoQueryMapper\Parser\DingoQueryMapper;

class ShowController extends Controller
{
    use Helpers;

    public function index(Request $request) : Response
    {
        $shows = DB::table('shows')
            ->select('name','show_url', DB::raw('LOWER(name) as name_lower'))
            ->get();

        dd($shows);

        $qm = new DingoQueryMapper($request);
        $shows = $qm->createFromCollection($shows)->paginate();

        return $this->response->paginator($shows, new ShowTransformer);
    }
}