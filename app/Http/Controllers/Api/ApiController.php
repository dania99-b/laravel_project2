<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\doctor;
use App\Models\Officer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{
    public function register(Request $request){
        $newuser = $request->validate([
            'first_name' => 'required|max:255|regex:/^[a-zA-Z]+$/u',
            'last_name' => 'required|max:255|regex:/^[a-zA-Z]+$/u',
            'email'=>'required|email:rfc',
            'password'=>'required|min:6|confirmed',
            'phone' => 'required |max:15',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender' => 'regex:/^[a-zA-Z]+$/u'
        ]);
        $upload=$request->file('photo')->move('appimages/',$request->file('photo')->getClientOriginalName());
    $mainuser = User::create([
            'first_name' => $newuser['first_name'],
            'last_name' => $newuser['last_name'],
            'email'=>$newuser['email'],
            'password'=>bcrypt($newuser['password']),
            'phone'=> $newuser['phone'],
        'photo' => $upload,
        'gender' => $newuser['gender']
        ]);
$mainuser->attachRole('user');
        return response()->json([
            'message'=>'user successfully registered',
            'user'=>$mainuser,
            'token'=>$mainuser->createToken('tokens')->plainTextToken

        ],'201');

    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return [
            'message' => 'logged out'
        ];




   /* public function get(Request $request){

        $doctors=User::get();

        if($doctors)
            $array=[
                'data'=>$doctors,
                'massage'=>'200'

            ];
        else{ $array=[
            'data'=>'null',
            'massage'=>'404'

        ];}
        return response( $array);
    }



public function add(Request $request)
{
    $user = User::create($request->all());
    if ($user) {
        $array = [
            'data' => $user,
            'massage' => '200'
        ];
    } else {
        $array = [
            'data' => 'null',
            'massage' => '404'

        ];
    }
    return response($array);*/
}
public function loginn(Request $request)
{

    $request->validate([
        'email' => 'required|email:rfc',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {

        return response(['success'=>false,'error' => 'Credentials not match'], 400)->header('Content-Type', 'application/json');
    }
    auth()->login($user);
    return response()->json([
        'success'=>true,
        'user' => $user,
        'token' => $user->createToken($request['email'], ['admin'])->plainTextToken,
        'role' =>$user->roles()->first()->name,

    ]);

}
public function get_login_user_info(){
        $user= \Auth::user();
return $user;

}

}

