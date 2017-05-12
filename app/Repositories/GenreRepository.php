<?php


namespace App\Repositories;

use App\Models\Genre;
use Illuminate\Support\Facades\DB;

class GenreRepository
{
    protected $genre;

    public function __construct(Genre $genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getGenres(){
        return DB::table('genres')
            ->orderBy('name', 'asc')
            ->get();
    }

}