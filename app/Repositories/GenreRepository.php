<?php


namespace App\Repositories;

use App\Models\Genre;
use Illuminate\Support\Facades\DB;

class GenreRepository
{
    protected $genre;

    /**
     * GenreRepository constructor.
     *
     * @param Genre $genre
     */
    public function __construct(Genre $genre)
    {
        $this->genre = $genre;
    }

    /**
     * On récupère tous les genres
     *
     * @return mixed
     */
    public function getGenres(){
        return DB::table('genres')
            ->orderBy('name', 'asc')
            ->get();
    }

}