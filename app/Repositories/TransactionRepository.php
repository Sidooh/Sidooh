<?php


namespace App\Repositories;

use App\Events\TransactionSuccessEvent;
use App\Models\Account;
use App\Models\AirtimeResponse;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use MrAtiebatie\Repository;

/**
 * App\Repositories\TransactionRepository
 *
 * @property int $id
 * @property float $amount
 * @property string $status
 * @property string $type
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $account_id
 * @property int|null $product_id
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRepository whereUpdatedAt($value)
 * @mixin IdeHelperTransactionRepository
 */
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
        Log::info('----------------- Transaction Status Update');

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
