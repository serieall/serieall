<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SeasonsSeeder extends Seeder
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
        DB::table('seasons')->insert([
            'thetvdb_id' => 16063,
            'name' => '1',
            'moyenne' => '18',
            'nbnotes' => '2',
            'show_id' => '1',
            'created_at' => $date,
            'updated_at' => $date
        ]);
    }
}
