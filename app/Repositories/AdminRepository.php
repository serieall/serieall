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

        $shows=DB::table('shows')
            ->select('shows.name, channels.name, nationalities.name, count(req.season), sum(req.episodes)')
            ->with('channels', 'nationalities')
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
            ->get()
            ->paginate($n);

        return compact('shows');
    }

}