<?php

use App\Models\UssdMenu;
use Illuminate\Database\Seeder;

class UssdMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $menus = [
            array(
                'title' => 'Welcome to Keheala',
                'is_parent' => 1,
                'type' => 1,
                'confirmation_message' => "",
            ),
            array(
                'title' => 'Treatment Verification',
                'is_parent' => 0,
                'type' => 2,
                'confirmation_message' => "",
            ),
            array(
                'title' => 'Compliance Score',
                'is_parent' => 0,
                'type' => 3,
                'confirmation_message' => "",
            ),
            array(
                'title' => 'TB Info',
                'is_parent' => 0,
                'type' => 1,
                'confirmation_message' => "",
            ),
            array(
                'title' => 'Supporter Chat',
                'is_parent' => 0,
                'type' => 2,
                'confirmation_message' => "",
            ),
            array(
                'title' => 'Ask TB Coordinator',
                'is_parent' => 0,
                'type' => 2,
                'confirmation_message' => "",
            ),
            array(
                'title' => 'Help',
                'is_parent' => 0,
                'type' => 1,
                'confirmation_message' => "",
            ),
//            array(
//                'title' => 'Repay Loan',
//                'is_parent' => 0,
//                'type' => 3,
//                'confirmation_message' => "Please transfer Ksh. XX to paybill number XXXXXX to pay your loan",
//            ),

        ];

        foreach ($menus as $menu) {
            UssdMenu::create($menu);
        }
    }
}
