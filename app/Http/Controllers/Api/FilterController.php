<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Trip;
use App\Models\trip_user;
use Illuminate\Http\Request;
use App\Models;
class FilterController extends Controller
{
   public function trips_filters(Request $request){


       if ($request->has('status'&&$request->has('trip_start') && $request->has('trip_end')))
       {
       $trip = Trip::where('trip_status', $request['status'])->where('trip_start', '>=', $request['trip_start'])->where('trip_end', '<=', $request['trip_end']);
       }


      else if ($request->has('status')) {
           $trip = Trip::where('trip_status', $request['status']);
       }

        else   if ($request->has('trip_start') && $request->has('trip_end')) {
               $trip = Trip::where('trip_start', '>=', $request['trip_start'])->where('trip_end', '<=', $request['trip_end']);
           }

           return $trip->get();


   }
    public function place_filters(Request $request)
    {
        if ($request->has('country_id') && $request->has('location') && $request->has('time_open') && $request->has('time_close')) {
            $place = Place::where('country_id', $request['country_id'])->where('location', $request['location'])->where('time_open', '>=', $request['time_open'])
                ->where('time_close', '<=', $request['time_close']);
    }

    else if($request->has('country_id')&&$request->has('location')){
        $place = Place::where('country_id', $request['country_id'])->where('location', $request['location']);

    }

    else if($request->has('country_id') && $request->has('time_open') && $request->has('time_close')) {
        $place = Place::where('country_id', $request['country_id'])->where('time_open', '>=', $request['time_open'])
            ->where('time_close', '<=', $request['time_close']);

    }

        else if($request->has('location') && $request->has('time_open') && $request->has('time_close')){
        $place = Place::where('location', $request['location'])->where('time_open', '>=', $request['time_open'])
            ->where('time_close', '<=', $request['time_close']);


    }

        else if ($request->has('location')) {
            $place = Place::where('location', $request['location']);
        }
    else if ($request->has('country_id')) {
        $place = Place::where('country_id', $request['country_id']);
    }

    else   if ($request->has('time_open') && $request->has('time_open')) {
        $place = Place::where('time_open', '>=', $request['time_close'])->where('time_close', '<=', $request['time_close']);
    }



        return $place->get();





}
    public function reservation_filters(Request $request){

        $reservation = trip_user::whereBetween('reservation_date',[$request->start_date,$request->end_date]);
        return  $reservation->get();

    }





}
