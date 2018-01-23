<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;

/**
 * Class CategoryRepository
 * @package App\Repositories
 */
class CategoryRepository
{
    protected $category;

    /**
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get all categories
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllCategories()
    {
        return $this->category::orderBy('name')->get();
    }
}