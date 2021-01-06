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
            ['title' => 'Sidooh Ambitious Agent', 'amount' => 475, 'active' => 1, 'level_limit' => 3],
            ['title' => 'Sidooh Booming Agent', 'amount' => 975, 'active' => 1, 'level_limit' => 5],
            ['title' => 'Sidooh Ambitious Agent', 'amount' => 4975, 'active' => 1, 'level_limit' => 3],
            ['title' => 'Sidooh Booming Agent', 'amount' => 9975, 'active' => 1, 'level_limit' => 5],
        ];


        foreach ($types as $type) {
            SubscriptionType::create($type);
        }
    }
}
