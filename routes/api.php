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
Route::post('/add_country',[\App\Http\Controllers\Api\CountryController::class,'add_country']);
Route::get('/get_all_country',[\App\Http\Controllers\Api\CountryController::class,'get_all_country']);
