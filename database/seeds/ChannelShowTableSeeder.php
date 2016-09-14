<?php

use Illuminate\Database\Seeder;

class ChannelShowTableSeeder extends Seeder
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
                DB::table('channel_show')->insert(array(
                    'show_id' => $i,
                    'channel_id' => $numbers[$j]
                ));
            }
        }
    }
}
