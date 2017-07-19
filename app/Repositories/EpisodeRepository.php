<?php


namespace App\Repositories;

use App\Models\Episode;
use App\Models\Show;

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
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|Episode
     */
    public function getEpisodeByID($id)
    {
        return $this->episode->findOrFail($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|Episode
     */
    public function getEpisodeWithSeasonShowByID($id)
    {
        return $this->episode->with(['season', 'directors', 'writers', 'guests', 'show' => function($q){
            $q->with('seasons');
        }])->findOrFail($id);
    }
}
