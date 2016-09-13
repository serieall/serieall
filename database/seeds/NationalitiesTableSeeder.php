<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NationalitiesTableSeeder extends Seeder
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
        for($i = 0; $i < 20; ++$i)
        {
            $date = $this->randDate();
            DB::table('nationalities')->insert(array(
                'name' => 'Nationalite' . $i,
                'nationality_url' => 'nationalite' . $i,
                'created_at' => $date,
                'updated_at' => $date
            ));
        }
    }
}
