<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Hash;
use Str;

class Users_auth extends Controller
{
    


    public function userCountery(Request $request){
        $data = $request->all();
        $validator = Validator::make($data,[
            'country' => 'required|max:5',
            'deviceId' => 'required|max:50',
        ]);

        if ($validator->fails()) {
            $response['status'] = false;
            $response['errors'] = $validator->errors();
            return $response;
        }

        $user = User::where('deviceId',$data['deviceId'])->first();
        if (!empty($user)) {
            $user->country = $data['country'];
            $user->deviceId = $data['deviceId'];
            $user->save();
        }else{
            User::create($data);
        }

        $response['status'] = true;
        $response['message'] = "success";

        return $response;

    }



    public function register(Request $request){
        $device_id = $request->header('device-id');
        if(!empty($device_id)) {
            $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'email' => 'required|unique:users,email|max:100',
            'phone' => 'required|unique:users,phone|max:100',
            'password' => 'required|max:100',
            'confirmPassword' => 'same:password',
            ]);

            if ($validator->fails()) {
                $data['status'] = false;
                $data['errors'] = $validator->errors();
                return $data;
            }

            $name = $request->name;
            $email = $request->email;
            $phone = $request->phone;
            $password = Hash::make($request->password);

            User::where('deviceId',$device_id)->update([
                'name' =>  $name,
                'email' =>  $email,
                'phone' =>  $phone,
                'password' => $password ,
                'api_token' => Str::random(50),
            ]);
            $user = User::where('deviceId',$device_id)->first();
            $data['status'] = true;
            $data['user'] = $user ;
        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }
        return $data;
    }


    public function login(Request $request){
        $user = User::where('email',$request->email)->first();

        if (!empty($user)) {
            if(Hash::check($request->password,$user->password)){
                $data['status'] = true;
                $data['user'] = $user;
                $data['user']->api_token = Str::random(50);
                $data['user']->save();
            }else{
                $data['status'] = false;
                $data['message'] = 'error password';
            }
        }else{
            $data['status'] = false;
            $data['message'] = 'error email';
        }
        return $data;
    }


}
