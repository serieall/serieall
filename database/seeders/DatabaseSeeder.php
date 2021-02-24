<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriesSeeder::class);
        $this->call(TempsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(SlogansSeeder::class);
    }
}
