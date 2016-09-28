<?php

use Illuminate\Database\Seeder;

class ArtistShowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 100; ++$i)
        {
            $numbers = range(1, 20);
            shuffle($numbers);
            $n = rand(3, 6);
            for($j = 1; $j < $n; ++$j)
            {
                DB::table('artist_show')->insert(array(
                    'show_id' => $i,
                    'artist_id' => $numbers[$j]
                ));
            }
        }
    }
}
