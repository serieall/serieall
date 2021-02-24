<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TempsSeeder extends Seeder
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
        DB::table('temps')->insert([
            'key' => 'token',
            'value' => '',
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        DB::table('temps')->insert([
            'key' => 'last_update',
            'value' => '1482331983',
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }
}
