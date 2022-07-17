<?php


namespace App\Traits;

use Illuminate\Http\Request;
use phpDocumentor\Reflection\File;

trait functrait
{
    function getGeocodeData(String $address) {
        $address = urlencode($address);
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
            return $geocodeData;

        }}
public function upload_photo(File $photo){
    $upload=$photo->move('appimages/',$photo->file('photo')->getClientOriginalName());
}
    public function displayImage($filename)

    {

        $path = storage_public('appimages/' . $filename);

        if (!File::exists($path)) {

            abort(404);

        }

        $file = File::get($path);

        $type = File::mimeType($path);

        $response = Response::make($file, 200);

        $response->header("Content-Type", $type);

        return $response;

    }

    function bcry_pass(String $password){
        return bcrypt($password);
   }




}


