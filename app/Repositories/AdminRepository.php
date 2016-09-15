<?php


namespace App\Repositories;

use App\Models\Show;
use Illuminate\Support\Facades\DB;

class AdminRepository
{
    protected $show;

    public function __construct(Show $show)
    {
        $this->show = $show;
    }

    public function getShowByName($n){
        return DB::table('shows')
            ->select('shows.name', DB::raw('count(req.season) as NB_SAISONS, sum(req.episodes) AS NB_EPISODES'))
            ->join(DB::raw('(SELECT seasons.id season, 
                        seasons.show_id, 
                        COUNT(episodes.id) episodes
                    FROM seasons 
                    INNER JOIN episodes 
                      ON episodes.season_id = seasons.id
                    GROUP BY seasons.id) as req'), 'req.show_id', '=', 'shows.id'
            )
            ->orderBy('shows.name')
            ->groupBy('shows.id')
            ->paginate($n);
    }

}