<?php
declare(strict_types=1);


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
     * EpisodeRepository constructor.
     *
     * @param Episode $episode
     * @internal param Season $season
     */
    public function __construct(Episode $episode)
    {
        $this->episode = $episode;
    }

    /**
     * Get episode by its ID
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|Episode
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getEpisodeByID($id)
    {
        return $this->episode::findOrFail($id);
    }

    /**
     * Get episode with seasons, artists and show by its id
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|Episode
     */
    public function getEpisodeWithSeasonShowByID($id)
    {
        return $this->episode::with(['season', 'directors', 'writers', 'guests', 'show' => function($q){
            $q->with('seasons');
        }])->findOrFail($id);
    }

    /**
     * Get episode by its number and he season id
     *
     * @param $seasonID
     * @param $episodeNumero
     * @return \Illuminate\Database\Eloquent\Model|mixed|null|static
     */
    public function getEpisodeByEpisodeNumeroAndSeasonID($seasonID, $episodeNumero)
    {
        return $this->episode::with('directors', 'writers', 'guests')
            ->where('episodes.numero', '=', $episodeNumero)
            ->where('episodes.season_id', '=', $seasonID)
            ->first();
    }

    /**
     * Get episode by its number, by the season id and the episode id
     *
     * @param $seasonID
     * @param $episodeNumero
     * @param $episodeID
     * @return \Illuminate\Database\Eloquent\Model|mixed|null|static
     */
    public function getEpisodeByEpisodeNumeroSeasonIDAndEpisodeID($seasonID, $episodeNumero, $episodeID) {
        return $this->episode::with('directors', 'writers', 'guests')
            ->where('episodes.numero', '=', $episodeNumero)
            ->where('episodes.id', '=',$episodeID)
            ->where('episodes.season_id', '=', $seasonID)
            ->first();
    }

    /**
     * Get rates by the id of episode
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|mixed|null|static
     */
    public function getRatesByEpisodeID($id)
    {
        return $this->episode::where('episodes.id', '=', $id)
            ->with('users')
            ->first();
    }

    /**
     * Get Episode with its ID and get seasons and shows in the same time
     *
     * @param $episode_id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function getEpisodeByIDWithSeasonIDAndShowID($episode_id) {
        return $this->episode::whereId($episode_id)
            ->with('season:seasons.id', 'show')
            ->select('episodes.id', 'episodes.season_id')
            ->first();
    }
}