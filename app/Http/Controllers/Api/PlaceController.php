<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
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


   }
    public function edit_place(Request $request)
    {

$place_id = $request['place_id'];
$place = Place::find($place_id);
if ($request->has('place_name')) {
    $place->place_name = $request->place_name;
    $place->update();

    $storename = $place['place_name'];
    $address = urlencode($storename);
    $googleMapUrl = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyD9PkTM1Pur3YzmO-v4VzS0r8ZZ0jRJTIU";
    $geocodeResponseData = file_get_contents($googleMapUrl);
    $responseData = json_decode($geocodeResponseData, true);
    if ($responseData['status'] == 'OK') {
        $latitude = isset($responseData['results'][0]['geometry']['location']['lat']) ? $responseData['results'][0]['geometry']['location']['lat'] : "";
        $longitude = isset($responseData['results'][0]['geometry']['location']['lng']) ? $responseData['results'][0]['geometry']['location']['lng'] : "";
        $formattedAddress = isset($responseData['results'][0]['formatted_address']) ? $responseData['results'][0]['formatted_address'] : "";
        if ($latitude && $longitude && $formattedAddress) {
            $geocodeData = array();
            array_push(
                $geocodeData,
                $latitude,
                $longitude,
                $formattedAddress
            );
        }
        $place::find($place_id);
        $place->langtiude = $geocodeData[0];
        $place->latitude = $geocodeData[1];
        $place->save();

    }
    }
    if ($request->has('photo')) {
        $upload = $request->file('photo')->move('appimages/', $request->file('photo')->getClientOriginalName());
        $place->photo = $upload;
        $place->update();
      //  dd($upload);
    }
    if ($request->has('id'))
        $place->country_id = $request->id;
    if ($request->has('time_open'))
        $place->time_open = $request->time_open;
    if ($request->has('time_close'))
        $place->time_close = $request->time_close;
    if ($request->has('fees'))
        $place->fees = $request->fees;
    if ($request->has('location'))
        $place->location = $request->location;
    if ($request->has('rate'))
        $place->rate = $request->rate;
    if ($request->has('place_price'))
        $place->place_price = $request->place_price;
    $place->update();

    $data[] = [
        'id' => $place->id,
        'place_name' => $place->place_name,
        'photo' => $place->photo,
        'langtiude' => $place->langtiude,
        'latitude' => $place->latitude,
        'time_open' => $place->time_open,
        'time_close' => $place->time_close,
        'location' => $place->location,
        'fees' => $place->fees,
        'rate' => $place->rate,
        'place_price' => $place->plave_price,
        'status' => 200,
    ];
    return response()->json($data);




}












    public function get_all_places(){
        $all_places=\App\Models\Place::all();

        foreach ($all_places as $d){
            $all_display[] =array('id'=>$d->id ,'place_name'=>$d->place_name);

        }
        return $all_display;

    }

    public function get_info_places(){
       $all_places=\App\Models\Place::all();
       return $all_places;
}

    public function delete_places(Request $request){
$place_id=$request['place_id'];
$place=Place::find($place_id);
$place->delete();
    }}




