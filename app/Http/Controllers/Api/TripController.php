<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Place;
use App\Models\reserv_places;
use App\Models\Trip;
use App\Models\trip_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class TripController extends Controller
{
    public function add_trip(Request $request)
    {

        $request->validate([
            'trip_name' => 'max:255|required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'trip_start' => 'required|max:20|date_format:Y-m-d H:i:s',
            'trip_end' => 'required|max:5000|date_format:Y-m-d H:i:s|after:trip_start',
            'duration' => 'max:5000|regex:/^[0-9]+$/',
            'trip_plane' => 'max:5000',
            'trip_status' => 'max:5000',
            'price' => 'required|max:5000|regex:/^\d*(\.\d{2})?$/',
            'note' => 'max:5000',
            'available_num_passenger' => 'numeric',
            'total_trip_price' => 'numeric',
            'discounts' => 'numeric'
        ]);
        $upload = $request->file('photo')->move('storage/appimages/', $request->file('photo')->getClientOriginalName());
        $new_trip = Trip::create([

            'trip_name' => $request['trip_name'],
            'photo' => $upload,
            'trip_start' => $request['trip_start'],
            'trip_end' => $request['trip_end'],
            'duration' => $request['duration'],
            'trip_plane' => $request['trip_plane'],
            'trip_status' => $request['trip_status'],
            'price' => $request['price'],
            'note' => $request['note'],
            'total_trip_price' => $request['total_trip_price'],
            'available_num_passenger' => $request['available_num_passenger'],
            'discounts' => $request['discounts'],
            'user_id' => Auth::id()

        ]);
        $trip_id = Trip::where('trip_name', $request['trip_name'])->get()->pluck('id');
        $id = $request->input('place_id');
        $prices = $request['place_trip_price'];
        $c = \App\Models\Place::whereIn('id', $id)->get();
        for ($ii = 0; $ii < count($c); $ii++) {
            $new_trip->places()->attach($c[$ii], ['place_trip_price' => $prices[$ii]]);
        }

    }

    public function get_trips_places()
    {

        $all_trip = Trip::all();
        foreach ($all_trip as $d) {
            $trips[] = array('trip_id' => $d->id, 'trip_name' => $d->trip_name, 'photo' => $d->photo, 'trip_start' => $d->trip_start, 'trip_end' => $d->trip_end, 'duration' => $d->duration, 'trip_plane' => $d->trip_plane, 'trip_status' => $d->trip_status, 'price' => $d->price, 'note' => $d->note, 'available_num_passenger' => $d->available_num_passenger, 'places' => $d->places()->get());


        }
        return $trips;
    }

    public function get_places_for_specific_trip(Request $request)
    {
        $trip = new Trip();
        $type_id = $request['id'];
        $place_trip[] = $trip->find($type_id)->places()->get();
        return $place_trip;
    }

    public function add_reservation(Request $request)
    {
        $trip_non_chose = 0.0;
        $user = auth()->user()->id;
        $confirm_button = $request['confirm_button'];
        $trip_id = $request['trip_id'];
        $passenger_number = $request['passenger_number'];
        $reservation_date = now()->format('Y-m-d');
        $places_id = $request->input('places_id');
        $total_money = $request['total_money'];
        $trip = Trip::find($trip_id);
        // dd($trip->discounts);
        if ($trip->available_num_passenger - $passenger_number >= 0) {


            auth()->user()->tripmany()->attach($trip_id, ['passenger_number' => $passenger_number, 'reservation_date' => $reservation_date, 'total_money' => $total_money]);

            $db = DB::table('trip_user')->latest()->first();

            $trip_user = new Trip_user();
            $trip_price = $trip->total_trip_price;
            $trip_user = Trip_user::find($db->id);
/////////count price of none choosen country
            $result = 0.0;
            if ($trip->places()->whereNotIn('place_id', $places_id)->first(['place_trip_price']) == null) {

                $trip_user->reservation_price = $passenger_number * ($trip->total_trip_price - ($trip->total_trip_price * $trip->discounts));
                $trip_user->save();
            } else {

                $all_places_no_choosen[] = $trip->places()->whereNotIn('place_id', $places_id)->first(['place_trip_price'])->place_trip_price;

                for ($i = 0; $i < count($all_places_no_choosen); $i++)
                    $result = $result + $all_places_no_choosen[$i];
                $reservation_price = $trip->total_trip_price - $result;
                $trip_user->reservation_price = $passenger_number * ($reservation_price - ($reservation_price * $trip->discounts));
                $trip_user->save();
            }

            foreach ($places_id as $ids) {
                $trip_user->places()->attach(['place_id' => $ids,]);

            }
            Trip::where('id', $trip_id)->decrement('available_num_passenger', $passenger_number);
        } else return "entered passenger_number larger than the total trip passenger";

    }

    public function show_user_reservation()
    {
        $user_id = auth()->user()->id;
        return trip_user::where('user_id', $user_id)->get();
    }

    public function cancelled_reservation(Request $request)
    {
        $reservation = $request['selected_reserv'];
        $user_id = auth()->user()->id;
       $deletd_reservation= trip_user::where('id', $request['selected_reserv']);
        $deletd_details=reserv_places::where('trip_user_id', $request['selected_reserv']);
       // dd(  $deletd_details);
        $deletd_reservation->delete();
        $deletd_details->delete();

    }
}
