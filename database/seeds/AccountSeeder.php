<?php

use App\Model\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $accounts = [
            ['phone' => '254710000000', 'telco_id' => 1,],
            ['phone' => '254710000001', 'telco_id' => 1,],
            ['phone' => '254710000002', 'telco_id' => 1,],
            ['phone' => '254710000003', 'telco_id' => 1,],
            ['phone' => '254710000004', 'telco_id' => 1,],

            ['phone' => '254710000005', 'telco_id' => 1, 'referrer_id' => mt_rand(1, 5)],
            ['phone' => '254710000006', 'telco_id' => 1, 'referrer_id' => mt_rand(1, 5)],
            ['phone' => '254710000007', 'telco_id' => 1, 'referrer_id' => mt_rand(1, 5)],
            ['phone' => '254710000008', 'telco_id' => 1, 'referrer_id' => mt_rand(1, 5)],
            ['phone' => '254710000009', 'telco_id' => 1, 'referrer_id' => mt_rand(1, 5)],
            ['phone' => '254710000010', 'telco_id' => 1, 'referrer_id' => mt_rand(1, 5)],
        ];

        foreach ($accounts as $account) {
            Account::create($account);
        }
    }
}
