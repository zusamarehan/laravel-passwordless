<?php

namespace App\Console\Commands;

use App\Jobs\RemoveExpiredLoginCookieJob;
use Illuminate\Console\Command;

class RemoveExpiredLoginCookies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pudding:removeexpiredlogincookies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The Command used to remove Login Cookie from the database after expiry';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch(new RemoveExpiredLoginCookieJob);
    }
}
