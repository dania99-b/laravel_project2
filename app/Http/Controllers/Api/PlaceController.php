<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\place;
use Geocoder\Laravel\Facades\Geocoder;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
   public function add_place(Request $request){
       $variable=$request->validate([
           'place_name'=>'max:255|required',
           'time_open'=>'max:20',
           'time_close'=>'max:20',
           'fees'=>'max:5000',
           'location'=>'max:5000',
           'langtiude'=>'max:5000',
           'latitude'=>'max:5000',
           'rate'=>'max:5000',
           'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

       ]);
       $new_place=place::create(
           [
               'place_name'=>$variable['place_name'],
               'time_open'=>$variable['time_open'],
               'time_close'=>$variable['time_close'],
               'fees'=>$variable['fees'],
               'location'=>$variable['location'],
               'langtiude'=>$variable['langtiude'],
               'latitude'=>$variable['latitude'],
               'rate'=>$variable['rate'],
           ]
       );


   }}

