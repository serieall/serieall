<?php


namespace App\Repositories;

use App\Models\Artist;
use App\Models\Show;

use App\Repositories\ShowRepository;

use Illuminate\Support\Facades\DB;

/**
 * Class ArtistRepository
 * @package App\Repositories
 */
class ArtistRepository
{
    /**
     * @var Artist
     */
    protected $artist;
    protected $show;
    protected $showRepository;

    /**
     * ArtistRepository constructor.
     *
     * @param Artist $artist
     * @param Show $show
     * @param \App\Repositories\ShowRepository $showRepository
     */
    public function __construct(Artist $artist,
                                Show $show,
                                ShowRepository $showRepository)
    {
        $this->artist = $artist;
        $this->show = $show;
        $this->showRepository = $showRepository;
    }

    /**
     * On récupère tous les artistes
     *
     * @return mixed
     */
    public function getArtists(){
        return DB::table('artists')
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * On récupère les artistes d'une série en fonction de son ID
     *
     * @param $show
     * @return \Illuminate\Database\Eloquent\Collection
     * @internal param $id
     */
    public function getActorsByShowID($show)
    {
        return $show->actors()->get();
    }
}