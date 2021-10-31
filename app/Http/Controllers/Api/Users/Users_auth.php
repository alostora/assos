<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

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





}
