<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EpisodesTableSeeder extends Seeder
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
        for($i = 0; $i < 2000; ++$i)
        {
            $date = $this->randDate();
            DB::table('episodes')->insert([
                'thetvdb_id' => rand(1, 10),
                'numero' => rand(1, 10),
                'name' => 'Episode' . $i,
                'name_fr' => 'EpisodeFR' . $i,
                'resume' => 'Résumé' . $i . ' Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'ba' => 'BA' . $i . ' Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'diffusion_us' => $date,
                'diffusion_fr' => $date,
                'moyenne' => rand(0,20),
                'nbnotes' => rand(0,50),
                'created_at' => $date,
                'updated_at' => $date,
                'season_id' => rand(1, 500)
            ]);

        }
    }
}
