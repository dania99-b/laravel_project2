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
            'available_num_passenger' => 'numeric'
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
            'available_num_passenger' => $request['available_num_passenger'],
            'user_id' => Auth::id()

        ]);

        $id = $request->input('id');

        $c = \App\Models\Place::whereIn('id', $id)->get();
        $new_trip->places()->attach($c);
    }

    public function get_trips_places()
    {

        $all_trip = Trip::all();
        foreach ($all_trip as $d) {
            $trips[] = array('trip_id' => $d->id,'trip_name' => $d->trip_name, 'photo' => $d->photo, 'trip_start' => $d->trip_start, 'trip_end' => $d->trip_end, 'duration' => $d->duration, 'trip_plane' => $d->trip_plane, 'trip_status' => $d->trip_status, 'price' => $d->price, 'note' => $d->note, 'available_num_passenger' => $d->available_num_passenger, 'places' => $d->places()->get());


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
        $user = auth()->user()->id;
        $confirm_button = $request['confirm_button'];
        $trip_id = $request['trip_id'];
        $passenger_number = $request['passenger_number'];
        $reservation_date = now()->format('Y-m-d');
        $places_id = $request->input('places_id');
        $part_money = $request['part_money'];

        auth()->user()->tripmany()->attach($trip_id, ['passenger_number' => $passenger_number, 'reservation_date' => $reservation_date, 'part_money' => $part_money]);

        $db = DB::table('trip_user')->latest()->first();

        $trip = Trip::find($trip_id);
        $trip_user = new Trip_user();

        $trip_user = Trip_user::find($db->id);

        foreach ($places_id as $ids) {
            $trip_user->places()->attach(['place_id' => $ids]);

        }
        if ($confirm_button == 'yes') {
            Trip::where('id', $trip_id)->decrement('available_num_passenger', $passenger_number);
        }

     //   trip_user::where('part_money', null)->where('created_at', '<', Carbon::now()->subMinute(2))->delete();

       $d = $trip->places()->whereIN('place_id', $places_id)->get()->pluck('place_name');

    }
    public function search(Request $request) {
        $data = User::with('instruments')
            ->where('user_type', 'teacher')
            ->orWhere('fname', 'like', '%' . $request->term . '%' )
            ->orWhere('fname', 'like', $request->term . '%' )
            ->orWhere('lname', 'like', '% ' . $request->term . '%' )
            ->orWhere('lname', 'like', $request->term . '%' )
            ->orWhere('email', 'like', '% ' . $request->term . '%' )
            ->orWhere('email', 'like', $request->term . '%' )
            ->orWhere('profession', 'like', '%' . $request->term . '%' )
            ->orWhere('profession', 'like', $request->term . '%' )
            ->limit(10)
            ->get();

        return response()->json($data);
    }



}
