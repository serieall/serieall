<?php


namespace App\Repositories;

use App\Models\Artist;
use App\Jobs\AddShowFromTVDB;
use App\Jobs\UpdateShowManually;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    /**
     * ShowRepository constructor.
     * @param Artist $artist
     */
    public function __construct(Artist $artist)
    {
        $this->artist = $artist;
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {

    }

    /**
     * @return mixed
     */
    public function getArtists(){
        return DB::table('artists')
            ->orderBy('name', 'asc')
            ->get();
    }
}