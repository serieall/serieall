<?php

namespace Database\Factories;

use App\Models\Show;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * ArticleFactory.
 */
class ShowFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Show::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $faker = $this->faker;

        return [
            'thetvdb_id' => $faker->randomDigit(),
            'show_url' => $faker->slug,
            'name' => $faker->name,
            'name_fr' => $faker->name,
            'synopsis' => $faker->realText(),
            'synopsis_fr' => $faker->realText(),
            'format' => 40,
            'annee' => 2021,
            'encours' => '1',
            'diffusion_us' => '2021-09-19',
            'diffusion_fr' => '2021-09-19',
            'particularite' => '',
        ];
    }
}
