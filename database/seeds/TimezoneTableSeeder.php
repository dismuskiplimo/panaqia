<?php

use Illuminate\Database\Seeder;

class TimezoneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(Storage::disk('local')->get('sql/timezones.sql'));
    }
}
