<?php

namespace App\Console\Commands;

use App\Helpers\AfricasTalking\AfricasTalkingApi;
use App\Models\AirtimeResponse;
use App\Repositories\ProductRepository;
use Illuminate\Console\Command;

class QueryAirtimeStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'airtime:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queries for airtime status from AT';

    /**
     * @var AfricasTalkingApi
     */
    private $AT;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->AT = new AfricasTalkingApi();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        //
//        TODO: Will we need both statuses? ['Sent', 'Queued']
        $transactions = AirtimeResponse::whereStatus('Sent')->get();
        $success = $errors = [];

        foreach($transactions as $transaction) {
            try {
                $results = $this->AT->transactionStatus($transaction->requestID);

                $resp = [
                    'requestId' => $transaction->requestID,
                    'status'    => $results['data']->status,
                ];

                $success[$transaction->requestID] = $results['data']->status;

                (new ProductRepository())->airtimeCallback($resp);

            } catch (\Exception $e) {
                $errors[$transaction->requestID] = $e->getMessage();
            }
        }

        $results = ['total' => count($transactions), 'successful' => $success, 'errors' => $errors];
        dd($results);
    }
}
