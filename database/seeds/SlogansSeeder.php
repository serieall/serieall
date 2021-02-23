
<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SlogansSeeder extends Seeder
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
        DB::table('slogans')->insert([
            'message' => 'plop',
            'source' => 'plop',
            'url' => 'plop',
            'created_at' => $date,
            'updated_at' => $date
        ]);
    }
}
