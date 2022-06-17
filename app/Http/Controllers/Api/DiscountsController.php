<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\discount;
use App\Models\Place;
use Illuminate\Http\Request;

class DiscountsController extends Controller
{
    public function add_discount(Request $request){

        $variable = $request->validate([
            'trip_id' => 'max:255|required',
            'time_start'=>'date_format:H:i',
            'time_end'=>'date_format:H:i|after:time_open',
            'discount_rate'=>'max:255|regex:/(^[A-Za-z0-9 ]+$)+/',



        ]);
        $upload=$request->file('photo')->move('appimages/',$request->file('photo')->getClientOriginalName());
        $country_id=$request ['id'];
        $discounts= new discount();
        $discounts->trip_id = $variable['trip_id'];
        $discounts->time_open = $request['time_start'];
        $discounts->time_close = $request['time_end'];
        $discounts->discount_rate = $request['discount_rate'];



    }
}
