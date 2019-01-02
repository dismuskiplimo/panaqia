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
        $this->call(CurrencySeeder::class);
        $this->call(ContactTypeSeeder::class);
        $this->call(OptionTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(EventCategorySeeder::class);
        $this->call(TimezoneTableSeeder::class);
        $this->call(SocialLogoTableSeeder::class);
    }
}
