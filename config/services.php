<?php
return array(
    'mailgun' =>
        array(
            'domain' => NULL,
            'secret' => NULL,
            'endpoint' => 'api.mailgun.net',
        ),
    'postmark' =>
        array(
            'token' => NULL,
        ),
    'ses' =>
        array(
            'key' => '',
            'secret' => '',
            'region' => 'us-east-1',
        ),
    'at' =>
        array(
            'key' => '24f8a51e90338e4d2a6ebb81899fb4dc66099df456338be9da55cd8b5ce196f7',
            'username' => 'sandbox',
            'phone' => NULL,
            'env' => 'production',
            'sms' =>
                array(
                    'key' => 'a53e86bcf72ff0e103130e5442504410fdd6d0ef32827fd2794e3caefb92c191',
                    'username' => 'sidooh_sms',
                    'from' => 'Sidooh',
                ),
            'airtime' =>
                array(
                    'key' => '89770c2faea7f33dce6ca5605a0cd7b9e810a999af8ea0c051a5e504d2380928',
                    'username' => 'sidooh_airtime',
                ),
            'ussd' =>
                array(
                    'code' => '*384*99#',
                ),
        ),
    'sidooh' =>
        array(
            'earnings' =>
                array(
                    'users_percentage' => 0.6,
                ),
            'tagline' => 'Sidooh, Makes You Money with Every Purchase.',
            'mpesa' =>
                array(
                    'env' => 'local',
                    'b2c' =>
                        array(
                            'phone' => '254708374149',
                            'min_amount' => '10',
                            'max_amount' => '70000',
                        ),
                ),
            'utilities_enabled' => true,
            'utilities_provider' => 'TANDA',
            'services' =>
                array(
                    'notify' =>
                        array(
                            'enabled' => true,
                            'url' => 'http://sidooh-notify.herokuapp.com/api/notifications',
                        ),
                ),
        ),
);
