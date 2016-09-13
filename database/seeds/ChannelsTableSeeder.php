<?php

use Illuminate\Database\Seeder;

class ChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('channels')->delete();

        for($i = 0; $i < 20; ++$i)
        {
            $date = $this->randDate();
            DB::table('channels')->insert(array(
                'name' => 'Chaine' . $i,
                'pays' => 'Pays' . $i,
                'channel_url' => 'chaine' . $i,
                'created_at' => $date,
                'updated_at' => $date
            ));
        }
    }
}
