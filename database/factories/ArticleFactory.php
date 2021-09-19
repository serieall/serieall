<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * ArticleFactory.
 */
class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $faker = $this->faker;

        return [
            'name' => $faker->name,
            'article_url' => $faker->slug,
            'intro' => $faker->text,
            'content' => $faker->paragraph(5),
            'image' => '',
            'frontpage' => 0,
            'state' => 1,
        ];
    }
}
