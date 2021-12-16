<?php


namespace App\Repositories;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use MrAtiebatie\Repository;

class DashboardRepository
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
    public function __construct() {
        $this->model = app(Account::class);
    }

    public function statistics(): array {
//        Try and get only specific fields...
        $transactions = Transaction::whereType('PAYMENT')
            ->with([
                'account' => function($query) {
                    return $query->select(['id', 'phone', 'user_id'])->with(['user:id,name']);
                }
            ])
            ->with([
                'payment' => function($query) {
                    return $query->select(['payable_id', 'status']);
                }
            ])
            ->select(['id', 'description', 'account_id', 'amount', 'status', 'updated_at'])
            ->latest()
            ->limit(16)
            ->get();


        $pendingTransactions = $transactions->filter(fn ($transaction) => $transaction->status == 'pending');

        return [
            'recentTransactions'  => $transactions,
            'pendingTransactions' => $pendingTransactions,
        ];
    }
}
