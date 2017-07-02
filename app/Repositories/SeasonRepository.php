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
        return $this->season->where('show_id', '=', $id)
            ->with('episodes')
            ->orderBy('seasons.name', 'asc')
            ->get();
    }

    /**
     * Récupère une saison d'une série grâce à on ID.
     * On ajoute les épisodes, les scénaristes, réalisateurs et guests.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSeasonEpisodesBySeasonID($id){
        return $this->season->with('episodes')
            ->findOrFail($id);
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

    public function getSeasonByID($id)
    {
        return $this->season->findOrFail($id);
    }
}
