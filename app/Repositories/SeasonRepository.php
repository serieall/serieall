<?php


namespace App\Repositories;

use App\Models\Episode_user;
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
     * @return \Illuminate\Database\Eloquent\Collection|static[]|Season
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
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|Season
     */
    public function getSeasonByID($id)
    {
        return $this->season->findOrFail($id);
    }

    /**
     * Récupère une saison, la série associée et les épisodes associés via l'ID de la saison
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|Season
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
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|Season
     */
    public function getSeasonWithShowByID($id)
    {
        return $this->season
            ->with('show')
            ->findOrFail($id);
    }

    public function getSeasonsWithEpisodesForShowByID($id)
    {
        return $this->season->where('show_id', '=', $id)
            ->with('episodes')
            ->orderBy('seasons.name', 'asc')
            ->get();
    }

    /**
     * @param $showID
     * @param $seasonName
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSeasonEpisodesBySeasonNameAndShowID($showID, $seasonName)
    {
        return $this->season
            ->with('episodes')
            ->withCount('episodes')
            ->where('seasons.name', '=', $seasonName)
            ->where('seasons.show_id', '=', $showID)
            ->first();
    }
}
