<?php


namespace App\Helpers\Safaricom;


use App\Helpers\Safaricom\Requests\B2B;
use App\Helpers\Safaricom\Requests\B2C;
use App\Helpers\Safaricom\Requests\Balance;
use App\Helpers\Safaricom\Requests\C2B;
use App\Helpers\Safaricom\Requests\Reversal;
use App\Helpers\Safaricom\Requests\STK;
use App\Helpers\Safaricom\Requests\Transaction;

class Mpesa
{
    /**
     * Initiate a business to business transaction.
     *
     * @return B2B
     */
    public function b2b()
    {
        return new B2B();
    }

    /**
     * Initiate a business to customer transaction.
     *
     * @return B2C
     */
    public function b2c()
    {
        return new B2C();
    }

    /**
     * Initiate a balance enquiry.
     *
     * @return Balance
     */
    public function balance()
    {
        return new Balance();
    }

    /**
     * Initialize a customer to business transaction.
     *
     * @return C2B
     */
    public function c2b()
    {
        return new C2B();
    }

    /**
     * Initiate a transaction reversal.
     *
     * @return Reversal
     */
    public function reversal()
    {
        return new Reversal();
    }

    /**
     * Initiate a transaction status check.
     *
     * @return Transaction
     */
    public function transaction()
    {
        return new Transaction();
    }

    /**
     * Initiate a LIPA NA MPESA ONLINE transaction using STK push.
     *
     * @return STK
     */
    public function STK()
    {
        return new STK();
    }
}
