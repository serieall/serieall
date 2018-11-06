<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ShowsSeeder extends Seeder
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
            'thetvdb_id' => 79126,
            'show_url' => 'the-wire',
            'name' => 'The Wire',
            'name_fr' => 'Sur écoute',
            'synopsis' => 'Unlike most television crime dramas, which neatly introduce and then solve a case all in the space of one hour, HBO\'s THE WIRE follows one single drug and homicide investigation throughout the length of an entire season. Centered on the drug culture of inner-city Baltimore, the series\' storyline unfolds from the points of view of both the criminals lording the streets and the police officers determined to bring them down.',
            'synopsis_fr' => 'Quand la police s\'efforce de démanteler un réseau tentaculaire de trafic de drogue et du crime à Baltimore.',
            'format' => '60',
            'annee' => '2002',
            'encours' => '0',
            'diffusion_fr' => '2002-06-02',
            'diffusion_us' => '2002-06-02',
            'particularite' => '',
            'moyenne' => '18',
            'nbnotes' => '2',
            'created_at' => $date,
            'updated_at' => $date
        ]);
    }
}
