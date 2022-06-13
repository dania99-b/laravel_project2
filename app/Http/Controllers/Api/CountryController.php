<?php


namespace App\Http\Controllers\Api;

use App\Models\Officer;
use App\Models\Place;
use Geocoder\Model\Country;
use Illuminate\Http\Request;
use PhpParser\Node\Scalar\String_;

class CountryController
    {
    public function addplace_tocountry(Request $request){
        $variable = $request->validate([
            'place_name' => 'max:255|required',
            'time_open'=>'date_format:H:i',
            'time_close'=>'date_format:H:i|after:time_open',
            'fees'=>'max:255|regex:/(^[A-Za-z0-9 ]+$)+/',
            'location'=>'max:255',
            'rate'=>'max:10|numeric',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',


        ]);
        $upload=$request->file('photo')->move('appimages/',$request->file('photo')->getClientOriginalName());
        $country = \App\Models\Country::where('country_name', $request['country_name'])->first()->id;
        $place= new Place();
        $place->place_name = $variable['place_name'];
        $place->time_open = $request['time_open'];
        $place->time_close = $request['time_close'];
        $place->fees = $request['fees'];
        $place->location = $request['location'];
        $place->rate = $request['rate'];
        $place->country_id=$country;
        $place->photo = $upload;

        $storename=$place['place_name'];
        $address = urlencode($storename);
        $googleMapUrl = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyD9PkTM1Pur3YzmO-v4VzS0r8ZZ0jRJTIU";
        $geocodeResponseData = file_get_contents($googleMapUrl);
        $responseData = json_decode($geocodeResponseData, true);
        if($responseData['status']=='OK') {
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
            $place::find($request->id);
            $place->langtiude = $geocodeData[0];
            $place->latitude = $geocodeData[1];
            $place->save();


        }

    }


    public function get_place_country(Request $request)

    {
        $id = \App\Models\Country::where(
        'country_name',$request['country_name'])->first()->id;
        $c=\App\Models\Country::find($id)->place()->get();
        return $c;
    }

    public function add_country(Request $request)
    {

        $variable = $request->validate([
            'country_name' => 'max:255|required|regex:/^[a-zA-Z]+$/u',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'langtiude' => 'max:5000',
            'latitude' => 'max:5000',

        ]);
        $upload = $request->file('photo')->move('appimages/', $request->file('photo')->getClientOriginalName());


        $new_country = \App\Models\Country::create(
            [
                'country_name' => $variable['country_name'],

                'photo' => $upload,

            ]
        );
        $storename = $variable['country_name'];
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
            $new_country::find($request->id);
            $new_country->langtiude = $geocodeData[0];
            $new_country->latitude = $geocodeData[1];
            $new_country->save();


        }
    }

    public function get_all_country()
    {

    $all_country=\App\Models\Country::all();

     foreach ($all_country as $d){
         $all_display[] =array('county name'=>$d->country_name ,'photo'=>$d->photo,'langtiude'=>$d->langtiude,'latitude'=>$d->latitude,'places'=>$d->place()->get());

    }
     return $all_display;

    }


    function getGeocodeData(Request $address) {
        $address = urlencode($address);
        $googleMapUrl = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyD9PkTM1Pur3YzmO-v4VzS0r8ZZ0jRJTIU";
        $geocodeResponseData = file_get_contents($googleMapUrl);
        $responseData = json_decode($geocodeResponseData, true);
        if($responseData['status']=='OK') {
            $latitude = isset($responseData['results'][0]['geometry']['location']['lat']) ? $responseData['results'][0]['geometry']['location']['lat'] : "";
            $longitude = isset($responseData['results'][0]['geometry']['location']['lng']) ? $responseData['results'][0]['geometry']['location']['lng'] : "";
            $formattedAddress = isset($responseData['results'][0]['formatted_address']) ? $responseData['results'][0]['formatted_address'] : "";
            if($latitude && $longitude && $formattedAddress) {
                $geocodeData = array();
                array_push(
                    $geocodeData,
                    $latitude,
                    $longitude,
                    $formattedAddress
                );
                return $geocodeData;
            } else {
                return false;
            }
        } else {
            echo "ERROR: {$responseData['status']}";
            return false;
        }
    }


public function update_offices(Request $request )
{
$office=Officer::find($request->id);
$office->office_name=$request->office_name;
$office->office_email=$request->office_email;
$office->password=$request->password;
$office->office_phone=$request->office_phone;
$res=$office->save();
if($request)
    return 'updated succesfully';
else
    return 'failed';

  }
  public function get_country_name_id(){
      $all_country=\App\Models\Country::all();

      foreach ($all_country as $d){
          $display[] =array('country_id'=>$d->id,'county name'=>$d->country_name );

      }
      return $display;


  }

}


