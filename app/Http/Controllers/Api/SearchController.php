<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Place;
use App\Models\Trip;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function country_search(Request $request)
    {
        $data = Country::select("country_name","photo","langtiude","latitude")->where("country_name","LIKE","%{$request['country_name']}%")->get();

        return response()->json($data);
    }


    public function place_search(Request $request)
    {
        $data = Place::select("place_name","time_open","time_close","langtiude","latitude","rate","photo","place_price")->where("place_name","LIKE","%{$request['data']}%")->get();

        return response()->json($data);
    }
    public function trip_search(Request $request)
    {
        $data = Trip::select("trip_name","photo","trip_start","trip_end","duration","price","availabe_num_passenger")->where("place_name","LIKE","%{$request['place_name']}%")->get();

        return response()->json($data);
    }

    public function country_place_search(Request $request)
    {
        //$data = Trip::select("trip_name","photo","trip_start","trip_end","duration","price","availabe_num_passenger")->where("place_name","LIKE","%{$request['place_name']}%")->get();
        $q = $request['data'];
       // return response()->json($data);
        $showcampaign = Country::join('places','places.country_id', '=', 'countries.id')
            ->where('country_name','LIKE', '%'.$q.'%')
            ->orWhere('place_name', 'LIKE','%'.$q.'%')
            ->get();
        return $showcampaign;
    }




}
