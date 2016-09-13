<?php

use Illuminate\Database\Seeder;

class NationalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nationalities')->delete();

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
