<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "A",
            "username" => "A",
            "id_number" => 12345678,
            "email" => "aa@a.a",
            "password" => Hash::make(12345678)
        ]);

        // $this->call(UsersTableSeeder::class);

//        $this->call(TelcoSeeder::class);
//        $this->call(AccountSeeder::class);
//        $this->call(ReferralSeeder::class);
//        $this->call(SubAccountSeeder::class);
//        $this->call(SubscriptionTypeSeeder::class);

//        $this->call(UssdMenuSeeder::class);
//        $this->call(UssdMenuItemSeeder::class);
    }
}
