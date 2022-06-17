<?php

namespace App\Console\Commands;

use App\Models\reserv_places;
use App\Models\trip_user;
use Carbon\Carbon;
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
        $trip_user=trip_user::where('part_money', null)->where('reservation_date', '<=', Carbon::now()->subDays(3))->get();
        foreach ($trip_user as $r){
            $r->delete();
            $r->places()->detach();
       ;}

    }
}
