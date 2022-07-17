<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\ApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/*Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});*/
Route::apiResource('/user',\App\Http\Controllers\Api\ApiController::class)->middleware('auth:sanctum');

Route::post('/register',[\App\Http\Controllers\Api\ApiController::class,'register']);
Route::get('/get',[\App\Http\Controllers\Api\ApiController::class,'get'])->middleware('auth:api');;;
Route::post('/add',[\App\Http\Controllers\Api\ApiController::class,'add']);
Route::post('/login',[\App\Http\Controllers\Api\ApiController::class,'login']);
Route::post('/logout', [\App\Http\Controllers\Api\ApiController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/bytoken', function() {
    return auth()->user();
})->middleware('auth:sanctum');
Route::post('/add_place',[\App\Http\Controllers\Api\PlaceController::class,'add_place']);

Route::post('/get_place',[\App\Http\Controllers\Api\CountryController::class,'get_place_country']);

Route::get('/get_all_country',[\App\Http\Controllers\Api\CountryController::class,'get_all_country']);


Route::group(['middleware' => ['auth:sanctum','ability:officer']], function() {
    Route::post('/login_officerr', [\App\Http\Controllers\Api\ApiController::class,'login_officer']);
});
Route::group(['middleware' => ['auth:sanctum']], function() {

});

  Route::post('/geocode', [\App\Http\Controllers\Api\CountryController::class,'getGeocodeData']);

  Route::put('/office', [\App\Http\Controllers\Api\CountryController::class,'update_offices']);
Route::get('/check',[\App\Http\Controllers\Api\DashboardController::class,'check']);

    Route::post('/login',[\App\Http\Controllers\Api\ApiController::class, 'loginn']);

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum','role:admin']], function() {
    Route::post('/add_admin', [\App\Http\Controllers\Api\DashboardController::class, 'register_admin']);
    Route::post('/add_officer', [\App\Http\Controllers\Api\DashboardController::class, 'register_officer']);
    Route::get('/get_users', [\App\Http\Controllers\Api\DashboardController::class, 'getall_user']);
    Route::post('/add_country',[\App\Http\Controllers\Api\CountryController::class,'add_country']);
});

Route::post('/add_place',[\App\Http\Controllers\Api\CountryController::class,'addplace_tocountry']);
Route::group(['prefix' => 'officer', 'middleware' => ['auth:sanctum','role:officer']], function()
{
Route::post('/add_trip',[\App\Http\Controllers\Api\TripController::class,'add_trip']);
Route::get('/get_all_places',[\App\Http\Controllers\Api\PlaceController::class, 'get_all_places']);
Route::post('edit_place',[\App\Http\Controllers\Api\PlaceController::class, 'edit_place']);
    Route::post('delete_places',[\App\Http\Controllers\Api\PlaceController::class, 'delete_places']);

});

 Route::get('/get_trip_place',[\App\Http\Controllers\Api\TripController::class, 'get_trips_places']);
Route::get('/get_trip_withdiscount',[\App\Http\Controllers\Api\TripController::class, 'get_trips_places_withdiscount']);
Route::post('/get_specific_trip',[\App\Http\Controllers\Api\TripController::class, 'get_places_for_specific_trip']);
Route::get('/get_country_name_id',[\App\Http\Controllers\Api\CountryController::class, 'get_country_name_id']);


Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum','role:user']], function() {
Route::post('/add_reservation',[\App\Http\Controllers\Api\TripController::class, 'add_reservation']);
Route::post('/edit_userinfo',[\App\Http\Controllers\Api\ApiController::class, 'profileedit']);
Route::post('/changepassword',[\App\Http\Controllers\Api\ApiController::class, 'ChangePassword']);
Route::post('/show_user_reservation',[\App\Http\Controllers\Api\TripController::class, 'show_user_reservation']);
Route::post('/cancelled_reservation',[\App\Http\Controllers\Api\TripController::class, 'cancelled_reservation']);
    Route::post('/tripsfilters',[\App\Http\Controllers\Api\FilterController::class, 'trips_filters']);
    Route::post('/placesfilters',[\App\Http\Controllers\Api\FilterController::class, 'place_filters']);
    Route::post('/reservationsfilters',[\App\Http\Controllers\Api\FilterController::class, 'reservation_filters']);
    Route::post('/edit_reserv',[\App\Http\Controllers\Api\TripController::class, 'edit_reserv']);
    Route::post('/get_reservation',[\App\Http\Controllers\Api\ApiController::class,'get_user_reserv']);

});



Route::get('/delete',[\App\Http\Controllers\Api\TripController::class, 'delete']);
Route::post('/place_autocomplete',[\App\Http\Controllers\Api\SearchController::class, 'place_search']);
Route::post('/trip_autocomplete',[\App\Http\Controllers\Api\SearchController::class, 'trip_search']);
Route::post('/country_place_autocomplete',[\App\Http\Controllers\Api\SearchController::class, 'country_place_search']);
Route::group([ 'middleware' => ['auth:sanctum']], function() {
Route::get('/logged_info',[ApiController::class, 'get_login_user_info']);
});
Route::post('/',function (Request $req){
    $url = 'https://fcm.googleapis.com/fcm/send';
    $dataArr = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'id' => $req->id,'status'=>"done");
    $notification = array('title' =>$req->title, 'text' => $req->body, 'sound' => 'default', 'badge' => '1',);
    $arrayToSend = array('to' => "/topics/all", 'notification' => $notification, 'data' => $dataArr, 'priority'=>'high');
    $fields = json_encode ($arrayToSend);
    $headers = array (
        'Authorization: key=' . "AAAAB5opTlw:APA91bFubtjflF96aVcHg4NHKE_IWiY47Cs_u49gvw298Pb0LG5ag18CCf0sufI165f099qd_nnaiTOkc-1hXwC3tQH4DmNH6eiGEWfvr2KvKnaZT-A3FzMwLBGrOGLemee5jogNC_wj",
        'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
    //var_dump($result);
    curl_close ( $ch );
    return $result;

});

Route::post('/gett',[ApiController::class, 'report_office']);
Route::post('/not',[\App\Http\Controllers\Api\NotificationController::class, 'send']);
Route::get('/information_places',[\App\Http\Controllers\Api\PlaceController::class, 'get_info_places']);
Route::get('/get_all_office',[\App\Http\Controllers\Api\ApiController::class, 'get_all_office']);
Route::post('/add_to_map',[\App\Http\Controllers\Api\MapController::class, 'add_To_map']);


