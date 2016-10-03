<?php

use Illuminate\Database\Seeder;

class ProfessionsTableSeeder extends Seeder
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
            DB::table('professions')->insert(array(
                'name' => 'Profession' . $i,
                'profession_url' => 'profession' . $i,
                'created_at' => $date,
                'updated_at' => $date
            ));
        }
    }
}

