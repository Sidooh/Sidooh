<?php

return [
    /*
     |------------------------------------------------------
     | Set sandbox mode
     | ------------------------------------------------------
     | Specify whether this is a test app or production app
     | Sandbox base url: https://sandbox.safaricom.co.ke
     | Production base url: https://api.safaricom.co.ke
     |
     */
    'sandbox' => env('MPESA_SANDBOX', true),
    /*
   |--------------------------------------------------------------------------
   | Cache credentials
   |--------------------------------------------------------------------------
   |
   | If you decide to cache credentials, they will be kept in your app cache
   | configuration for sometime. Reducing the need for many requests for
   | generating credentials
   |
   */
    'cache_credentials' => true,
    /*
   |--------------------------------------------------------------------------
   | C2B array
   |--------------------------------------------------------------------------
   |
   | If you are accepting payments enter application details and shortcode info
   |
   */
    'c2b' => [
        /*
         * Consumer Key from developer portal
         */
        'consumer_key' => env('MPESA_KEY'),
        /*
         * Consumer secret from developer portal
         */
        'consumer_secret' => env('MPESA_SECRET'),
        /*
         * HTTP callback method [POST,GET]
         */
        'callback_method' => 'POST',
        /*
         * Your receiving paybill or till umber
         */
        'short_code' => env('MPESA_STK_SHORTCODE'),
        /*
         * Passkey , requested from mpesa
         */
        'passkey' => env('MPESA_STK_PASS_KEY'),
        /*
         * --------------------------------------------------------------------------------------
         * Callbacks:
         * ---------------------------------------------------------------------------------------
         * Please update your app url in .env file
         * Note: This package has already routes for handling this callback.
         * You should leave this values as they are unless you know what you are doing
         */
        /*
         * Stk callback URL
         */
        'stk_callback' => env('APP_URL') . '/payments/callbacks/stk_callback',
        /*
         * Data is sent to this URL for successful payment
         */
        'confirmation_url' => env('APP_URL') . '/payments/callbacks/confirmation',
        /*
         * Mpesa validation URL.
         * NOTE: You need to email MPESA to enable validation
         */
        'validation_url' => env('APP_URL') . '/payments/callbacks/validate',
    ],
    /*
      |--------------------------------------------------------------------------
      | B2C array
      |--------------------------------------------------------------------------
      |
      | If you are sending payments to customers or b2b
      |
      */
    'b2c' => [
        /*
         * Sending app consumer key
         */
        'consumer_key' => env('MPESA_KEY'),
//            'Ei4lr5xbDZXS9XEAZ1BhNE4xCBcAYGVyA',
        /*
         * Sending app consumer secret
         */
        'consumer_secret' => env('MPESA_SECRET'),
//            'eMhCDmzFQyx1SNSZ',
        /*
         * Shortcode sending funds
         */
        'short_code' => 600643,
        /*
        * This is the user initiating the transaction, usually from the Mpesa organization portal
        * Make sure this was the user who was used to 'GO LIVE'
        * https://org.ke.m-pesa.com/
        */
        'initiator' => 'TestInit643',
        /*
         * The user security credential.
         * Go to https://developer.safaricom.co.ke/test_credentials and paste your initiator password to generate
         * security credential
         */
        'security_credential' => 'NuaLznkkv0eEG0g51dESOPbAIg5IpAMRJSM74gO1FMhk+d36su7S2ND0mrlmE2XwMO0Gz0sk4NTaDpPGVK5VsUwQChsXbixmO3JL2TTEAWAVq/YNO6GN3sj6L/+654HzRufM2UKifuTQdBY3FitxFDMjwn5XbXg7QXXiNzv1ZBxyZhZmianAqrSFms5hS7fAZRVHoJnQ5yup4fgrjrK2KpNK5UjbEacRgymLMT5nVDKJRcvENa0YooiWt1Wo8PekaeqcV7V5W61esiCDH37AqMXyWxnHJ28fEF4WknCzsK19qMXOiMGrUA6IVNIjU6uYihCpoP361WZWFvSlSaP70A==',
        /*
         * Notification URL for timeout
         */
        'timeout_url' => env('APP_URL') . '/payments/callbacks/timeout_url/',
        /**
         * Result URL
         */
        'result_url' => env('APP_URL') . '/payments/callbacks/result/',
    ],
    'b2b' => [
        /*
         * Sending app consumer key
         */
        'consumer_key' => env('MPESA_KEY'),
//            'Ei4lr5xbDZXS9XEAZ1BhNE4xCBcAYGVyA',
        /*
         * Sending app consumer secret
         */
        'consumer_secret' => env('MPESA_SECRET'),
//            'eMhCDmzFQyx1SNSZ',
        /*
         * Shortcode sending funds
         */
        'short_code' => 600000,
        /*
        * This is the user initiating the transaction, usually from the Mpesa organization portal
        * Make sure this was the user who was used to 'GO LIVE'
        * https://org.ke.m-pesa.com/
        */
        'initiator' => 'testapi',
        /*
         * The user security credential.
         * Go to https://developer.safaricom.co.ke/test_credentials and paste your initiator password to generate
         * security credential
         */
        'security_credential' => 'NuaLznkkv0eEG0g51dESOPbAIg5IpAMRJSM74gO1FMhk+d36su7S2ND0mrlmE2XwMO0Gz0sk4NTaDpPGVK5VsUwQChsXbixmO3JL2TTEAWAVq/YNO6GN3sj6L/+654HzRufM2UKifuTQdBY3FitxFDMjwn5XbXg7QXXiNzv1ZBxyZhZmianAqrSFms5hS7fAZRVHoJnQ5yup4fgrjrK2KpNK5UjbEacRgymLMT5nVDKJRcvENa0YooiWt1Wo8PekaeqcV7V5W61esiCDH37AqMXyWxnHJ28fEF4WknCzsK19qMXOiMGrUA6IVNIjU6uYihCpoP361WZWFvSlSaP70A==',
        /*
         * Notification URL for timeout
         */
        'timeout_url' => env('APP_URL') . '/payments/callbacks/timeout_url/',
        /**
         * Result URL
         */
        'result_url' => env('APP_URL') . '/payments/callbacks/result/',
    ],
    /*
     * Configure slack notifications to receive mpesa events and callbacks
     */
    'notifications' => [
        /*
         * Slack webhook URL
         * https://my.slack.com/services/new/incoming-webhook/
         */
//        'slack_web_hook' => 'https://hooks.slack.com/services/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',
        /*
         * Get only important notifications
         * You wont be notified for failed stk push transactions
         */
//        'only_important' => true,
    ],
];
