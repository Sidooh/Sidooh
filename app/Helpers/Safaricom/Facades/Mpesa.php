<?php


namespace App\Helpers\Safaricom\Facades;


use Illuminate\Support\Facades\Facade;

class Mpesa extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mpesa-api';
    }

}
