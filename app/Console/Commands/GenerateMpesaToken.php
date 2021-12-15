<?php

namespace App\Console\Commands;

use App\Helpers\Safaricom\MpesaClient;
use Illuminate\Console\Command;

class GenerateMpesaToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mpesa:generateToken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates an Mpesa Token';

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
        $client = new MpesaClient();
        $token = $client->getAccessToken();

        $this->info('Token retrieved: ' . $token);
    }
}
