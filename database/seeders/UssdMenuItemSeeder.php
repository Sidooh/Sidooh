<?php

use App\Models\UssdMenuItem;
use Illuminate\Database\Seeder;

class UssdMenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $menu_items = [
//            array(
//                'menu_id' => 1,
//                'description' => 'Buy Airtime',
//                'next_menu_id' => 2,
//                'step' => 0,
//                'confirmation_phrase' => '',
//            ),


            array(
                'menu_id' => 1,
                'description' => 'Verify Treatment',
                'next_menu_id' => 2,
                'step' => 0,
                'confirmation_phrase' => '',
            ),
            array(
                'menu_id' => 1,
                'description' => 'Compliance Score',
                'next_menu_id' => 3,
                'step' => 0,
                'confirmation_phrase' => '',
            ),
            array(
                'menu_id' => 1,
                'description' => 'TB info',
                'next_menu_id' => 4,
                'step' => 0,
                'confirmation_phrase' => '',
            ),
            array(
                'menu_id' => 1,
                'description' => 'Supporter chat',
                'next_menu_id' => 5,
                'step' => 0,
                'confirmation_phrase' => '',
            ),
            array(
                'menu_id' => 1,
                'description' => 'Ask TB Coordinator',
                'next_menu_id' => 6,
                'step' => 0,
                'confirmation_phrase' => '',
            ),
            array(
                'menu_id' => 1,
                'description' => 'Help',
                'next_menu_id' => 7,
                'step' => 0,
                'confirmation_phrase' => '',
            ),
            array(
                'menu_id' => 2,
                'description' => 'Mini Statements',
                'next_menu_id' => 7,
                'step' => 0,
                'confirmation_phrase' => '',
            ),

        ];

        foreach ($menu_items as $item) {
            UssdMenuItem::create($item);
        }


    }
}
