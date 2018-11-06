<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EpisodeUserSeeder extends Seeder
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
        DB::table('episode_user')->insert([
            'episode_id' => '1',
            'user_id' => '1',
            'rate' => '20',
            'created_at' => $date,
            'updated_at' => $date
        ]);
        DB::table('episode_user')->insert([
            'episode_id' => '1',
            'user_id' => '2',
            'rate' => '16',
            'created_at' => $date,
            'updated_at' => $date
        ]);
    }
}
