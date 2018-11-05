<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{

    /**
     * Génère une date aléatoire
     *
     * @return mixed
     */
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
        $date = $this->randDate();
        DB::table('users')->insert([
            'username' => 'admin',
            'user_url' => 'admin',
            'email' => 'bmayelle@hotmail.fr',
            'password' => '$2y$10$aO/pp1im2mg9sO9TonUFbu85ng4LZMZRCn8eft9wRq/QDYBQRPnYe',
            'role' => 1,
            'activated' => 1,
            'created_at' => $date,
            'updated_at' => $date
        ]);

        DB::table('users')->insert([
            'username' => 'testserieall',
            'user_url' => 'testserieall',
            'email' => 'testserieall@gmail.com',
            'password' => '$2y$10$aO/pp1im2mg9sO9TonUFbu85ng4LZMZRCn8eft9wRq/QDYBQRPnYe',
            'role' => 4,
            'activated' => 1,
            'created_at' => $date,
            'updated_at' => $date
        ]);
    }
}
