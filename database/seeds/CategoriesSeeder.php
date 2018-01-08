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
            'name' => 'News',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        DB::table('categories')->insert([
            'name' => 'Bilan',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        DB::table('categories')->insert([
            'name' => 'Dossier',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        DB::table('categories')->insert([
            'name' => 'Critique',
            'created_at' => $date,
            'updated_at' => $date
        ]);
        DB::table('categories')->insert([
            'name' => 'Focus',
            'created_at' => $date,
            'updated_at' => $date
        ]);
    }
}
