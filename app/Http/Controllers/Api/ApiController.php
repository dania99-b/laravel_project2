<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function register(Request $request){
        $newuser = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email'=>'required|email:rfc',
            'password'=>'required|min:6|confirmed',
            'phone' => 'required |max:15'
        ]);

    $mainuser = User::create([
            'first_name' => $newuser['first_name'],
            'last_name' => $newuser['last_name'],
            'email'=>$newuser['email'],
            'password'=>bcrypt($newuser['password']),
            'phone'=> $newuser['phone']
        ]);

        return response()->json([
            'message'=>'user successfully registered',
            'user'=>$mainuser,
            'token'=>$mainuser->createToken('tokens')->plainTextToken

        ],'201');

    }

    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required|email:rfc|',
            'password' => 'required|min:6'
        ]);

        if (!Auth::attempt($login)) {
            // return $this->error('Credentials not match', 401);

            return response(['error' => 'Credentials not match'], 400)->header('Content-Type', 'application/json');
        }

        return response()->json([
            'success'=>'true',
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ]);

    }


    public function logout($id,Request $request) {
        Auth::user()git ->where('id', $id)->delete();

// Get user who requested the logout
        $user = request()->user(); //or Auth::user()
// Revoke current user token
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

    }
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

