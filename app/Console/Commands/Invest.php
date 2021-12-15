<?php

namespace App\Console\Commands;

use App\Repositories\AccountRepository;
use Illuminate\Console\Command;

class Invest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sidooh:invest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invests Account Balances';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void {
        //
        $results = (new AccountRepository())->invest();

//        TODO: To be removed after testing auto assignment
        $x = (new AccountRepository())->calculateInterest(9);


        $this->info($x);
    }
}
