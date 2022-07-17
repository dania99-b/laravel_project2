<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\doctor;
use App\Models\Officer;
use App\Models\Trip;
use App\Models\trip_user;
use App\Models\TripUser;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Console\Input\Input;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        $newuser = $request->validate([
            'first_name' => 'required|max:255|regex:/^[a-zA-Z]+$/u',
            'last_name' => 'required|max:255|regex:/^[a-zA-Z]+$/u',
            'email' => 'required|email:rfc|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required |max:15',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender' => 'regex:/^[a-zA-Z]+$/u'
        ]);
        $upload = $request->file('photo')->move('appimages/', $request->file('photo')->getClientOriginalName());
        $mainuser = User::firstOrCreate([
            'first_name' => $newuser['first_name'],
            'last_name' => $newuser['last_name'],
            'email' => $newuser['email'],
            'password' => bcrypt($newuser['password']),
            'phone' => $newuser['phone'],
            'photo' => $upload,
            'gender' => $newuser['gender'],

        ]);
        $mainuser->attachRole('user');


        return response()->json([
            'message' => 'user successfully registered',
            'user' => $mainuser,
            'token' => $mainuser->createToken('tokens')->plainTextToken

        ], '201');

    }

    public function logout(Request $request)
    {
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

            return response(['success' => false, 'error' => 'Credentials not match'], 400)->header('Content-Type', 'application/json');
        }
        if ($user->blocked==1){
            return response(['success' => false, 'error' => 'blocked account'], 400)->header('Content-Type', 'application/json');

        }
        ///$request['device_token']
        auth()->login($user);
        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $user->createToken($request['email'], ['admin'])->plainTextToken,
            'role' => $user->roles()->first()->name,

        ]);

    }

    public function get_login_user_info()
    {
        $user = \Auth::user();
        return $user;

    }

    public function profileedit(Request $request)
    {
        $id = \Auth::user()->id;
        $users = user::find($id);
        if ($request->has('first_name'))
            $users->first_name = $request->first_name;
        if ($request->has('last_name'))
            $users->last_name = $request->last_name;
        if ($request->has('email'))
            $users->email = $request->email;
        if ($request->has('phone'))
            $users->phone = $request->phone;
        if ($request->has('photo')) {
            $upload = $request->file('photo')->move('storage/appimages/', $request->file('photo')->getClientOriginalName());
            $users->photo = $upload;
        }
        $users->update();

        $data[] = [
            'id' => $users->id,
            'first_name' => $users->first_name,
            'last_name' => $users->last_name,
            'photo' => $users->photo,
            'email' => $users->email,
            'phone' => $users->last_name,
            'status' => 200,
        ];
        return response()->json($data);

    }


    public function ChangePassword(Request $request){

        if($validator = Validator::make($request->all(),[
           'old_password'=>'required',
            'new_password'=>'required|confirmed|min:6|max:100',
         ]));

        if($validator->fails()){
            return response()->json([
                'message'=>'validation error',
                'errors'=>$validator->errors()
            ],400);}
      //  $user=$request->user();
            $id = \Auth::user()->id;
           $user = user::find($id);
           if(Hash::check($request->old_password,$user->password)){

            $user->password = bcrypt($request['new_password']);
           $user->save();
            return response()->json([
                'message'=>'password successfully updated',

            ],200);}
           else {return response()->json([
               'message'=>'old password not matched'
           ],400);}


}
    public function report_office(Request $request)
    {
        $input=$request['id'];
       $user= User::find($input);
       $user->numreports=$user->numreports+1;
        $user->save();
        if($user->numreports>=20){
            $user->blocked=true;
        $user->save();
        dd('blocked!!!');}

    }
    public function get_all_office(){
        $value='officer';
        $dd= User::with(['roles'])
            ->whereHas('roles', function($q) use($value) {
                $q->where('name', '=', $value);
            })->get();
      return $dd;

}
    public function get_user_reserv(){
        $result[]=array();
        $idd =\Auth::user()->id;
        $dd= Trip::with(['scopeUser'])
            ->whereHas('scopeUser', function($q) use($idd) {
                $q->where('user_id', '=', $idd);})->get();
            return response()->json($dd);


    }


}

