<?php
declare(strict_types=1);


namespace App\Repositories;

use App\Models\Slogan;


/**
 * Class SloganRepository
 * @package App\Repositories
 */
class SloganRepository {
    protected $slogan;

    /**
     * SloganRepository constructor.
     *
     * @param Slogan $slogan
     */
    public function __construct(Slogan $slogan)
    {
        $this->slogan = $slogan;
    }

    /**
     * Get all Slogans
     */
    public function getAllSlogans(){
        return $this->slogan->get();
    }
}
