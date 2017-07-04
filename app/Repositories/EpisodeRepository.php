<?php


namespace App\Repositories;

use App\Models\Episode;

/**
 * Class SeasonRepository
 * @package App\Repositories\Admin
 */
class EpisodeRepository
{
    protected $episode;

    /**
     * SeasonRepository constructor.
     *
     * @param Episode $episode
     * @internal param Season $season
     */
    public function __construct(Episode $episode)
    {
        $this->episode = $episode;
    }

    /**
     * Récupère un épisode grâce à son ID
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getEpisodeByID($id)
    {
        return $this->episode->findOrFail($id);
    }
}
