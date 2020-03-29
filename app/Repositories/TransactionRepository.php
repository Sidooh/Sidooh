<?php


namespace App\Repositories;

use App\Events\TransactionSuccessEvent;
use App\Model\Account;
use App\Model\Transaction;
use App\Models\AirtimeResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use MrAtiebatie\Repository;

class TransactionRepository extends Model
{
    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->model = app(Transaction::class);
    }

    public function statusUpdate(AirtimeResponse $airtime_response)
    {
        Log::info('------------------------ Transaction Status Update ' . now() . ' ---------------------- ');

        $airtime_request = $airtime_response->request;

        $responses = $airtime_request->responses;

//        TODO:: Remove Sent from successful
//        || $value->status == 'Sent'
        $successful = $responses->filter(function ($value, $key) {
            return $value->status == 'Success' || $value->status == 'Sent';
        });

        if (count($successful) == count($responses)) {

            $transaction = $airtime_request->transaction;

            $transaction->status = 'success';

            $transaction->save();

            $totalEarned = explode(" ", $airtime_request->totalDiscount)[1];

            event(new TransactionSuccessEvent($transaction, $totalEarned));
        }

    }

    public function updateToSuccess(Transaction $transaction)
    {
        $transaction->status = 'success';

        $transaction->save();
    }

    public function lastWithdrawal(Account $account, $type)
    {
        $trans = $account->transactions()->whereType('WITHDRAWAL')->whereDescription($type)->latest()->first();

        return $trans;
    }


}