<?php

namespace App\Console\Commands;

use App\Jobs\RemoveExpiredMagicCredentialsJob;
use Illuminate\Console\Command;

class RemoveExpiredMagicCredentialCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pudding:removeexpiredmagiccredentials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The Command used to remove Magic Credentials from the database after expiry';

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
        dispatch(new RemoveExpiredMagicCredentialsJob);
    }
}
