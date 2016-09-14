<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ShowsTableSeeder extends Seeder
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
        for($i = 0; $i < 100; ++$i)
        {
            $date = $this->randDate();
            DB::table('shows')->insert([
                'thetvdb_id' => rand(1, 10),
                'show_url' => 'titre' . $i,
                'name' => 'Série' . $i,
                'name_fr' => 'SérieFR' . $i,
                'synopsis' => 'Contenu' . $i . ' Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'format' => 45,
                'annee' => rand(2010, 2016),
                'encours' => rand (0,1),
                'createurs' => 'Createurs' . $i,
                'diffusion_us' => $date,
                'diffusion_fr' => $date,
                'moyenne' => rand(0,20),
                'moyenne_redac' => rand(0,20),
                'nbnotes' => rand(0,50),
                'taux_erectile' => rand(0,100),
                'avis_rentree' => 'Avis' . $i,
                'created_at' => $date,
                'updated_at' => $date
            ]);

        }
    }
}
