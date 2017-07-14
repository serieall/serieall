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

    /**
     * Récupère une saison par son ID
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getSeasonByID($id)
    {
        return $this->season->findOrFail($id);
    }

    /**
     * Récupère une saison, la série associée et les épisodes associés via l'ID de la saison
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getSeasonShowEpisodesBySeasonID($id)
    {
        return $this->season
            ->with('show', 'episodes')
            ->findOrFail($id);
    }

    /**
     * Récupère une saison via son ID et récuèper également la série associée
     *
     * @param $id
     */
    public function getSeasonWithShowByID($id)
    {
        return $this->season
            ->with('show')
            ->findOrFail($id);
    }
}
