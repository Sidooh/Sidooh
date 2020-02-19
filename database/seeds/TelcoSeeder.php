<?php

use App\Model\Telco;
use Illuminate\Database\Seeder;

class TelcoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $telcos = [
            ['initials' => 'SAFC', 'name' => 'Safaricom Limited',],
            ['initials' => 'AIRT', 'name' => 'Airtel Kenya Limited', 'active' => false],
        ];


        foreach ($telcos as $telco) {
            Telco::create($telco);
        }

    }
}
