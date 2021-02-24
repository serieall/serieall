<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Generate a random date.
     */
    private function randDate(): Carbon
    {
        return Carbon::createFromDate(null, rand(1, 12), rand(1, 28));
    }

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $date = $this->randDate();
        DB::table('users')->insert([
            'username' => 'admin',
            'user_url' => 'admin',
            'email' => 'toto@hotmail.fr',
            'password' => bcrypt(env('APP_ADMIN_PASSWORD', 'serieall')),
            'role' => 1,
            'activated' => 1,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }
}
