<?php


namespace App\Http\Controllers\Api;

use App\Models\Officer;
use Geocoder\Model\Country;
use Illuminate\Http\Request;

class CountryController
{
    public function get_place_country()
    {
        $ff = \App\Models\Place::find(1);
        return $ff->country_id;
    }

    public function add_country(Request $request)
    {
        $variable = $request->validate([
            'country_name' => 'max:255',
            'time_open' => 'max:20',
            'time_close' => 'max:20',
            'fees' => 'max:5000',
            'location' => 'max:5000',
             'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
  $upload=$request->file('photo')->store('appimages');


        $new_country = \App\Models\Country::create(
            [
                'country_name' => $variable['country_name'],

                'photo' => $upload,

            ]
        );
        $storename=$variable['country_name'];
        $address = urlencode($storename);
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
                );}
                $new_country::find($request->id);
                $new_country->langtiude=$geocodeData[0];
                $new_country->latitude=$geocodeData[1];
                $new_country->save();


    }}

    public function get_all_country(){



    $all_country=\App\Models\Country::all();

     foreach ($all_country as $d){
         $all_display[] =array('county name'=>$d->country_name ,'photo'=>$d->photo);

    }
     return $all_display;}
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
  public function update_offices(Request $request ){

$office=Officer::find($request->id);
$office->office_name=$request->office_name;
$office->office_email=$request->office_email;
$office->password=$request->password;
$office->office_phone=$request->office_phone;
$res=$office->save();
if($request)
    return 'updated succesfully';
else return 'failed';



  }


}


