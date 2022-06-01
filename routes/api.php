<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/get_place',[\App\Http\Controllers\Api\CountryController::class,'get_place_country']);

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

// /admin/add

    /*Route::middleware('role:admin')
        ->group(function(){
            Route::post('/login_adminn', [\App\Http\Controllers\Api\ApiController::class,'loginn']);
        });
Route::get('/login_officerr', [\App\Http\Controllers\Api\ApiController::class,'getall_user']);*/
