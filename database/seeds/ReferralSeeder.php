<?php

use App\Models\Referral;
use Illuminate\Database\Seeder;

class ReferralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $referrals = [
            ['referee_phone' => '254710000005', 'account_id' => mt_rand(1, 5), 'referee_id' => 6],
            ['referee_phone' => '254710000006', 'account_id' => mt_rand(1, 5), 'referee_id' => 7],
            ['referee_phone' => '254710000007', 'account_id' => mt_rand(1, 5), 'referee_id' => 8],
            ['referee_phone' => '254710000008', 'account_id' => mt_rand(1, 5), 'referee_id' => 9],
            ['referee_phone' => '254710000009', 'account_id' => mt_rand(1, 5), 'referee_id' => 10],
            ['referee_phone' => '254710000010', 'account_id' => mt_rand(1, 5), 'referee_id' => 11],

            ['referee_phone' => '254710000015', 'account_id' => mt_rand(3, 10)],
            ['referee_phone' => '254710000016', 'account_id' => mt_rand(4, 10)],
            ['referee_phone' => '254710000017', 'account_id' => mt_rand(5, 10)],
            ['referee_phone' => '254710000018', 'account_id' => mt_rand(5, 10)],
            ['referee_phone' => '254710000019', 'account_id' => mt_rand(6, 10)],
            ['referee_phone' => '254710000020', 'account_id' => mt_rand(7, 10)],
        ];

        foreach ($referrals as $referral) {
            Referral::create($referral);
        }
    }
}
