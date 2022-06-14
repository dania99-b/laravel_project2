<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class delete_reservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservation_delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description ='delete reservation after 3 day from reserv date automatically';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
