<?php


namespace App\Repositories;

use App\Models\Season;

/**
 * Class SeasonRepository
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
        ->orderBy('seasons.name', 'asc')
        ->get();
    }

    public function getSeasonsCountEpisodesForShowByID($id){
        return $this->season->where('show_id', '=', $id)
            ->withCount('episodes')
            ->orderBy('seasons.name', 'asc')
            ->get();
    }
}
