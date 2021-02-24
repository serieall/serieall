<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Genre;
use Illuminate\Support\Facades\DB;

/**
 * Class GenreRepository.
 */
class GenreRepository
{
    protected $genre;

    /**
     * GenreRepository constructor.
     */
    public function __construct(Genre $genre)
    {
        $this->genre = $genre;
    }

    /**
     * On récupère tous les genres.
     *
     * @return mixed
     */
    public function getGenres()
    {
        return DB::table('genres')
            ->orderBy('name', 'asc')
            ->get();
    }
}
