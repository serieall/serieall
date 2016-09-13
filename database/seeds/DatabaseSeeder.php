<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ShowsTableSeeder::class);
        $this->call(NationalitiesTableSeeder::class);
        $this->call(ChannelsTableSeeder::class);
        $this->call(ChannelShowTableSeeder::class);
        $this->call(NationalityShowTableSeeder::class);
    }
}
