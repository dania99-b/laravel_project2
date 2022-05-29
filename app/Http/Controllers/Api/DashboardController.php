<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Officer;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    public function register_officer(Request $request){
        $newuser = $request->validate([
            'office_name' => 'required|max:255',
            'office_email'=>'required|email:rfc',
            'password'=>'required|min:6|confirmed',
            'office_phone' => 'required |max:15'
        ]);

        $officer = Officer::Create([
            'office_name' => $newuser['office_name'],
            'office_email'=>$newuser['office_email'],
            'password'=>bcrypt($newuser['password']),
            'office_phone'=> $newuser['office_phone']
        ]);

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
            'admin_name' => 'required|max:255',
            'admin_email'=>'required|email:rfc',
            'password'=>'required|min:6|confirmed',
            'admin_phone' => 'required |max:15'
        ]);

        $admin = Admin::Create([
            'admin_name' => $newuser['admin_name'],
            'admin_email'=>$newuser['admin_email'],
            'password'=>bcrypt($newuser['password']),
            'admin_phone'=> $newuser['admin_phone']
        ]);

        if (isset($admin->createToken('tokens')->plainTextToken)) {
            return response()->json([
                'message'=>'user successfully registered',
                'admin'=>$admin,
                'token'=>$admin->createToken('tokens')->plainTextToken

            ],'201');
        }

    }
}
