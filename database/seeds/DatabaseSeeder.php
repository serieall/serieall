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
        #$this->call(ShowsTableSeeder::class);
        #$this->call(NationalitiesTableSeeder::class);
        #$this->call(ChannelsTableSeeder::class);
        #$this->call(ChannelShowTableSeeder::class);
        #$this->call(NationalityShowTableSeeder::class);
        #$this->call(SeasonsTableSeeder::class);
        #$this->call(EpisodesTableSeeder::class);
        #$this->call(ArtistsTableSeeder::class);
        #$this->call(GenresTableSeeder::class);
        #$this->call(GenreShowTableSeeder::class);
        #$this->call(ArtistShowTableSeeder::class);
        $this->call(ProfessionsTableSeeder::class);
    }
}
