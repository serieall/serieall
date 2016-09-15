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

        $shows=DB::table('shows', 'seasons')
            ->join('shows', 'seasons.show_id', '=', 'shows.id')
            ->join('episodes', 'seasons.id', '=', 'episodes.season_id')
            ->orderBy('shows.name')
            ->get()
            ->paginate($n);

        return compact('shows', 'episodes');
    }

}