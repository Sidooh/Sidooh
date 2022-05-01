<?php


namespace App\Listeners;

use App\Models\Payment;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
use DrH\Mpesa\Database\Entities\MpesaStkCallback;
use DrH\Mpesa\Events\C2bConfirmationEvent;

class C2bPaymentConfirmation
{
    /**
     * Handle the event.
     *
     * @param C2bConfirmationEvent $event
     * @return void
     */
    public function handle(C2bConfirmationEvent $event)
    {
        $c2b = $event->transaction;
        //Try to check if this was from STK
        $request = MpesaStkCallback::where("MpesaReceiptNumber", $c2b->TransID)->exists();

        if ($request)
            return;

//        Find account
        $accountRep = new AccountRepository();
        $account = $accountRep->findByPhone($c2b->MSISDN);

//        Create transaction
        $productRep = new ProductRepository();
        $product = $productRep->store(['name' => 'Voucher']);

        $transaction = new Transaction();

        $transaction->amount = $c2b->TransAmount;
        $transaction->type = 'PAYMENT';
        $transaction->description = "Voucher Purchase - $c2b->MSISDN";
        $transaction->account_id = $account->id;
        $transaction->product_id = $product->id;

        $transaction->save();

        $payment = new Payment([
            'amount' => $c2b->TransAmount,
            'status' => 'Complete',
            'type' => 'MPESA',
            'subtype' => 'C2B',
            'payment_id' => $c2b->id
        ]);

        $transaction->payment()->save($payment);

//        Purchase Voucher
        $voucherDetails = [
            'phone' => $c2b->MSISDN,
            'amount' => $c2b->TransAmount
        ];

        (new ProductRepository())->voucher($transaction, $voucherDetails);
    }
}
