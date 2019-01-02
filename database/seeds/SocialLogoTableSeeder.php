<?php

use Illuminate\Database\Seeder;

class SocialLogoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(Storage::disk('local')->get('sql/social-icons.sql'));
    }
}
