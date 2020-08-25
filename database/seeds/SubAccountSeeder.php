<?php

use App\Models\SubAccount;
use Illuminate\Database\Seeder;

class SubAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $sub_accounts = [

            ['in' => 25471, 'out' => 1, 'account_id' => 1],
            ['account_id' => 2],
            ['in' => 0000007, 'out' => 1, 'account_id' => 3],
            ['account_id' => 4],
            ['in' => 254, 'out' => 1, 'account_id' => 5],
            ['account_id' => 6],
        ];

        foreach ($sub_accounts as $account) {
            SubAccount::create($account);
        }
    }
}
