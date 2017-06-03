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
     *
     * @param Season $season
     */
    public function __construct(Season $season)
    {
        $this->season = $season;
    }

    /**
     * Récupère les saisons d'une série grâce à on ID.
     * On ajoute les épisodes, les scénaristes, réalisateurs et guests.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSeasonsEpisodesForShowByID($id){
        return $this->season->where('show_id', '=', $id)->with(['episodes' => function ($query)
        {
            $query->with('writers', 'directors', 'guests');
            $query->orderBy('episodes.numero', 'asc');
        }])
        ->orderBy('seasons.name', 'asc')
        ->get();
    }

    /**
     * Récupère les saisons d'une série grâce à son ID.
     * On ajoute également le nombre d'épisodes.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSeasonsCountEpisodesForShowByID($id){
        return $this->season->where('show_id', '=', $id)
            ->withCount('episodes')
            ->orderBy('seasons.name', 'asc')
            ->get();
    }
}
