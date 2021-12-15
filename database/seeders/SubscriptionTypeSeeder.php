<?php

use App\Models\SubscriptionType;
use Illuminate\Database\Seeder;

class SubscriptionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $types = [
            ['title' => 'Sidooh Aspiring Agent', 'amount' => 475, 'active' => 1, 'level_limit' => 3],
            ['title' => 'Sidooh Thriving Agent', 'amount' => 975, 'active' => 1, 'level_limit' => 5],
            ['title' => 'Sidooh Aspiring Agent', 'amount' => 4275, 'active' => 1, 'level_limit' => 3, 'duration' => 12],
            ['title' => 'Sidooh Thriving Agent', 'amount' => 8775, 'active' => 1, 'level_limit' => 5, 'duration' => 12],
        ];


        foreach ($types as $type) {
            SubscriptionType::create($type);
        }
    }
}
