<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Officer;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    public function __construct(){
$this->middleware(['role:admin']);

    }
    public function register_officer(Request $request){
        $newuser = $request->validate([
            'first_name' => 'required|max:255|regex:/^[a-zA-Z]+$/u',
            'last_name' => 'required|max:255|regex:/^[a-zA-Z]+$/u',
            'email'=>'required|email:rfc',
            'password'=>'required|min:6|confirmed',
            'phone' => 'required |max:15|numeric'
        ]);

        $officer =User::Create([
            'first_name' => $newuser['first_name'],
            'last_name' => $newuser['last_name'],
            'email'=>$newuser['email'],
            'password'=>bcrypt($newuser['password']),
            'phone'=> $newuser['phone']]);
      $officer->attachRole('officer');
        if (isset($officer->createToken('tokens')->plainTextToken)) {
            return response()->json([
                'message'=>'user successfully registered',
                'office'=>$officer,
                'token'=>$officer->createToken('tokens')->plainTextToken

            ],'201');
        }

    }
    public function register_admin(Request $request){
        $newuser = $request->validate([
            'first_name' => 'required|max:255|regex:/^[a-zA-Z]+$/u',
            'last_name' => 'required|max:255|regex:/^[a-zA-Z]+$/u',
            'email'=>'required|email:rfc',
            'password'=>'required|min:6|confirmed',
            'phone' => 'required |max:15|numeric'
        ]);

        $admin = User::Create([
            'first_name' => $newuser['first_name'],
            'last_name' => $newuser['last_name'],
            'email'=>$newuser['email'],
            'password'=>bcrypt($newuser['password']),
            'phone'=> $newuser['phone']]);
        $admin->attachRole('admin');
        $admin->attachPermission('register_office');
        if (isset($admin->createToken('tokens')->plainTextToken)) {
            return response()->json([
                'message'=>'user successfully registered',
                'admin'=>$admin,
                'token'=>$admin->createToken('tokens')->plainTextToken

            ],'201');
        }

    }
    public function check(){
        $user=User::find(5);
        if( $user->isAn('admin'))
            return 'yesss';
        else return 'nooo';
    }
    public function getall_user(){

        return $user=\App\Models\User::all();

        foreach ($user as $d){
            $all_display[] =array('first_name'=>$d->first_name ,'last_name'=>$d->last_name,'email'=>$d->email);

        }
        return $all_display;
    }
}
