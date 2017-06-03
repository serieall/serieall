<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TempsSeeder extends Seeder
{
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
        DB::table('temps')->insert([
            'key' => 'token',
            'value' => '',
            'created_at' => $date,
            'updated_at' => $date
        ]);

        DB::table('temps')->insert([
            'key' => 'last_update',
            'value' => '1482331983',
            'created_at' => $date,
            'updated_at' => $date
        ]);
    }
}
