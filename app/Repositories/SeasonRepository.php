<?php


namespace App\Repositories;

use App\Models\Season;
use Illuminate\Support\Facades\Log;

/**
 * Class AdminShowRepository
 * @package App\Repositories\Admin
 */
class SeasonRepository
{
    /**
    * @var Season
    */
    protected $season;

    /**
     * SeasonRepository constructor.
     * @param Season $season
     */
    public function __construct(Season $season)
    {
        $this->season = $season;
    }

    public function getSeasonsEpisodesForShowByID($id){
        return $this->season->where('show_id', '=', $id)->with(['episodes' => function ($query)
        {
            $query->with('writers', 'directors', 'guests');
            $query->orderBy('episodes.numero', 'asc');
        }])
        ->get();
    }
}
