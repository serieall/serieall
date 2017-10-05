<?php


namespace App\Repositories;

use App\Models\Episode;
use App\Models\Episode_user;
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

    public function getEpisodeByEpisodeNumeroAndSeasonID($seasonID, $episodeNumero)
    {
        return $this->episode
            ->with('directors', 'writers', 'guests')
            ->where('episodes.numero', '=', $episodeNumero)
            ->where('episodes.season_id', '=', $seasonID)
            ->first();
    }

    public function getEpisodeByEpisodeNumeroSeasonIDAndEpisodeID($seasonID, $episodeNumero, $episodeID) {
        return $this->episode
            ->with('directors', 'writers', 'guests')
            ->where('episodes.numero', '=', $episodeNumero)
            ->where('episodes.id', '=',$episodeID)
            ->where('episodes.season_id', '=', $seasonID)
            ->first();
    }

    public function getRatesByEpisodeID($id)
    {
        return $this->episode
            ->where('episodes.id', '=', $id)
            ->with('users')
            ->first();
    }
}