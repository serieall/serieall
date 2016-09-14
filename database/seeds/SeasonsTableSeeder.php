<?php

use Illuminate\Database\Seeder;

class SeasonsTableSeeder extends Seeder
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
        DB::table('seasons')->delete();

        for($i = 0; $i < 500; ++$i)
        {
            $date = $this->randDate();
            DB::table('seasons')->insert([
                'thetvdb_id' => rand(1, 10),
                'name' => rand(1,50),
                'ba' => 'BA' . $i . ' Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'moyenne' => rand(0,20),
                'nbnotes' => rand(0,50),
                'created_at' => $date,
                'updated_at' => $date,
                'show_id' => rand(1, 100)
            ]);

        }
    }
}
