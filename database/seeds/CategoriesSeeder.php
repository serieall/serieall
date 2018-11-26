<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CategoriesSeeder extends Seeder
{
    private function randDate()
    {
        return Carbon::createFromDate(null, rand(1, 12), rand(1, 28));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = $this->randDate();
        DB::table('categories')->insert([
            'name' => 'Actualité',
            'description' => 'Articles consacrés à l\'actualité sérielle.',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        DB::table('categories')->insert([
            'name' => 'Bilan',
            'description' => 'Articles consacrés au bilan d\'une série ou d\'une saison.',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        DB::table('categories')->insert([
            'name' => 'Critique',
            'description' => 'Articles consacrés aux critiques d\'épisodes.',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        DB::table('categories')->insert([
            'name' => 'Chronique',
            'description' => 'Articles spéciaux.',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        DB::table('categories')->insert([
            'name' => 'Dossier',
            'description' => 'Articles consacrés à une thématique particulière dans le monde des séries.',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        DB::table('categories')->insert([
            'name' => 'Focus',
            'description' => 'Articles consacrés à l\'aspect particulier d\'une série.',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        DB::table('categories')->insert([
            'name' => 'News',
            'description' => 'Articles consacrés aux actualités du site.',
            'created_at' => $date,
            'updated_at' => $date
        ]);

    }
}
