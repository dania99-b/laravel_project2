<?php


namespace App\Http\Controllers\Api;

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


    }

    public function get_all_country(){



    $all_country=\App\Models\Country::all();


     foreach ($all_country as $d){
         $all_display[] =array('county name'=>$d->country_name ,'photo'=>$d->photo);

    }
     return $all_display;}






}


