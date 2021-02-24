<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Slogan;

/**
 * Class SloganRepository.
 */
class SloganRepository
{
    protected $slogan;

    /**
     * SloganRepository constructor.
     */
    public function __construct(Slogan $slogan)
    {
        $this->slogan = $slogan;
    }

    /**
     * Get all Slogans.
     */
    public function getAllSlogans()
    {
        return $this->slogan->get();
    }

    /**
     * Retourne un slogan via son ID.
     *
     * @param $id
     *
     * @return Slogan|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getSloganByID($id)
    {
        return $this->slogan->whereId($id)->first();
    }
}
