<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlogansSeeder extends Seeder
{
    /**
     * Generate random date.
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
        DB::table('slogans')->insert([
            'message' => 'plop',
            'source' => 'plop',
            'url' => 'plop',
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }
}
