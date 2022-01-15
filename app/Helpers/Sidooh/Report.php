<?php


namespace App\Helpers\Sidooh;


use App\Models\Account;
use App\Models\Payment;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TransactionRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class Report
{
    /**
     * Account to generate report for.
     *
     * @var Account
     */
    protected $account;

    /**
     * Phone number to generate report for.
     *
     * @var string
     */
    protected $phone;

    /**
     * Starting time of report.
     *
     * @var string
     */
    protected $start_date;

    /**
     * Opening balance of report.
     *
     * @var string
     */
    protected $opening_balance;

    /**
     * Closing balance of report.
     *
     * @var string
     */
    protected $closing_balance;

    /**
     * Self earning of report.
     *
     * @var Collection
     */
    protected $self_earnings;

    /**
     * Self earning date of report.
     *
     * @var Carbon
     */
    protected $self_earnings_date;

    /**
     * Referral earnings of report.
     *
     * @var Collection
     */
    protected $referral_earnings;

    /**
     * Referral earning date of report.
     *
     * @var Carbon
     */
    protected $referral_earnings_date;

    /**
     * Withdrawals of report.
     *
     * @var Collection
     */
    protected $withdrawals;

    /**
     * Withdrawal date of report.
     *
     * @var Carbon
     */
    protected $withdrawals_date;


    /**
     * Make the initializations required to purchase airtime
     * @param $phone
     */
    public function __construct($phone)
    {
        $this->phone = $phone;

        $accRep = new AccountRepository();

        $this->account = $accRep->findByPhone($this->phone);

        $this->setStartDate();

    }

    private function setStartDate()
    {
        $transaction = (new TransactionRepository())->lastWithdrawal($this->account, 'Query - Earnings Report');

        $this->start_date = $transaction ? Carbon::createFromTimeStamp(strtotime($transaction->created_at)) : null;

//        Log::info([Carbon::createFromTimeStamp(strtotime($transaction->created_at)), $transaction]);
    }

    private function setEarnings()
    {
        $earnings = (new AccountRepository())->earnings($this->account, $this->start_date);

        $this->self_earnings = $earnings->filter(function ($earning) {
            return $earning->type == 'SELF';
        });

        $this->referral_earnings = $earnings->filter(function ($earning) {
            return $earning->type == 'REFERRAL';
        });

        $self_l = $this->self_earnings->last();
        $referral_l = $this->referral_earnings->last();

        $this->self_earnings_date = $self_l ? Carbon::createFromTimeStamp(strtotime($self_l->created_at)) : now();

        $this->referral_earnings_date = $referral_l ? Carbon::createFromTimeStamp(strtotime($referral_l->created_at)) : now();

    }

    private function setWithdrawals()
    {
        $this->withdrawals = (new AccountRepository())->withdrawals($this->account, $this->start_date);

        $withdrawals_l = $this->withdrawals->last();

        $this->withdrawals_date = $withdrawals_l ? Carbon::createFromTimeStamp(strtotime($withdrawals_l->created_at)) : now();

    }

    private function makeReport()
    {
//        TODO:: Opening balance from previous report...??? Using description column... Reports table? Modify Transactions table?
//        TODO:: Level breakdown... Store level in earnings?
//        TODO:: Fix Report dates

        $o_bal = 0;
        $o_bal_time = now()->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $self_e = $this->self_earnings->sum('earnings');
        $self_e_t = $this->self_earnings_date->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $referral_e = $this->referral_earnings->sum('earnings');
        $referral_e_t = $this->referral_earnings_date->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $redeemed_e = $this->withdrawals->sum('amount');
        $redeemed_e_t = $this->withdrawals_date->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $c_bal = $o_bal + $self_e + $referral_e - $redeemed_e;
        $c_bal_time = now()->timezone('Africa/Nairobi')->format(config("settings.sms_date_time_format"));

        $msg = "O.Bal: {$o_bal} as at {$o_bal_time} (Coming soon)\n\n";

        $msg .= "Self: {$self_e} as at {$self_e_t}\n";
        $msg .= "Referral: {$referral_e} as at {$referral_e_t}\n";
        $msg .= "Redeemed: {$redeemed_e} as at {$redeemed_e_t}\n";

        $msg .= "\nC.Bal: {$c_bal} as at {$c_bal_time}";

        return $msg;

    }

    public function generate()
    {
        Log::info('====== Report Generation ======');

        $this->setEarnings();

        $this->setWithdrawals();

        $report = $this->makeReport();

        $sms = $this->send($report);

        $productRep = new ProductRepository();
        $product = $productRep->store(['name' => 'Earnings Report']);

        $transaction = new Transaction();

        $transaction->amount = 1;
        $transaction->type = 'WITHDRAWAL';
        $transaction->description = 'Query - Earnings Report';
        $transaction->account_id = $this->account->id;
        $transaction->product_id = $product->id;
        $transaction->status = 'success';

        $transaction->save();

        $payment = new Payment([
            'amount' => 1,
            'status' => 'Success',
            'type' => 'Sidooh',
            'subtype' => 'Points',
            'payment_id' => $this->account->id
        ]);

        $transaction->payment()->save($payment);

    }

    private function send($msg)
    {
        NotificationRepository::sendSMS([$this->phone], $msg);
    }

    public function generateJson()
    {
        Log::info('====== Report Generation (Json) ======');

        $this->setEarnings();

        $this->setWithdrawals();

        return json_encode(get_object_vars($this));
    }

}
