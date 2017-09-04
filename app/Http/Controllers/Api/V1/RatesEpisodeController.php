<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Transformers\NationalitiesTransformer;
use App\Http\Transformers\RatesEpisodeTransformer;
use App\Models\Episode;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use Illuminate\Support\Facades\DB;

class RatesEpisodeController extends Controller
{
    use Helpers;

    public function index($episode_id) : Response
    {
        $rates = Episode::where('episodes.id', '=', $episode_id)
            ->with('users', 'season', 'show', 'directors', 'writers', 'guests')
            ->first();

        return $this->response->array($rates);
    }
}