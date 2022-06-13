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
           'place_name'=>'max:255|requireds',
           'time_open'=>'max:20|date_format:H:i',
           'time_close'=>'max:20|date_format:H:i|after:time_open',
           'fees'=>'max:5000|regex:/(^[A-Za-z0-9 ]+$)+/',
           'location'=>'max:5000|regex:/^[a-zA-Z]+$/u',
           'langtiude'=>'max:5000',
           'latitude'=>'max:5000',
           'rate'=>'max:5000|numeric',
           'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           'place_price' => 'numeric',
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
               'place_price'=>$variable['place_price'],
           ]
       );


   }}

