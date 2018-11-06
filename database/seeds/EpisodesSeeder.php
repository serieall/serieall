<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EpisodesSeeder extends Seeder
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
        DB::table('episodes')->insert([
            'thetvdb_id' => 303029,
            'numero' => '1',
            'name' => 'The Target',
            'name_fr' => 'La cible',
            'resume' => '... when it\'s not your turn." - McNultyDuring the trial of D\'Angelo Barksdale, a mid-level dealer accused of murder, the prosecution\'s star witness recants her testimony, resulting in a not guilty verdict. After the trial, Detective James "Jimmy" McNulty is taken to task for his indiscretion. Meanwhile, D\'Angelo is free to return to work, but he soon discovers that he\'s been demoted.',
            'resume_fr' => 'Après avoir vu le jeune Angelo Barksdale, accusé de meurtre, jugé «non coupable», le magistrat contacte le détective James McNulty de la divison des homicides. Ce dernier lui révèle que l\'affaire pourrait être liée à une série d\'assassinats restés impunis à cause des mesures d\'intimidation ou d\'élimination des témoins pratiquées par le gang d\'Avon Barksdale. Peu après, le lieutenant Cedric Daniels reçoit l\'ordre d\'ouvrir une enquête.',
            'diffusion_us' => '2002-06-02',
            'diffusion_fr' => '2002-06-02',
            'moyenne' => '18',
            'nbnotes' => '2',
            'season_id' => '1',
            'created_at' => $date,
            'updated_at' => $date
        ]);
    }
}
