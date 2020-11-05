<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->call(TelcoSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(ReferralSeeder::class);
        $this->call(SubAccountSeeder::class);

//        $this->call(UssdMenuSeeder::class);
//        $this->call(UssdMenuItemSeeder::class);
    }
}
