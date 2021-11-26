<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_address;
use Validator;
use Hash;
use Str;
use Auth;
use URL;
use File;
use App\Mail\Forget_pass;

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
            $err = $validator->errors()->toArray();
            $data['message'] = array_values($err)[0][0];
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

            if($validator->fails()) {
                $data['status'] = false;
                $err = $validator->errors()->toArray();
                $data['message'] = array_values($err)[0][0];
                return $data;
            }

            User::where('deviceId',$device_id)->update([
                'name' =>  $request->name,
                'email' =>  $request->email,
                'phone' =>  $request->phone,
                'password' => Hash::make($request->password),
                'api_token' => Str::random(50),
            ]);

            $user = User::where('deviceId',$device_id)->first();
            $user->image = !empty($user->image) ? URL::to('uploads/users/'.$user->image) : URL::to('uploads/users/defaultLogo.jpeg');
            $data['status'] = true;
            $data['user'] = $user ;
        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }
        return $data;
    }




    public function socialSignUp(Request $request){

        $device_id = $request->header('device-id');
        $country = $request->header('country');
        $requestData = $request->all();
        $requestData['api_token'] = Str::random(100);
        $data['status'] = true;

        $user = User::where('email',$request->email)->first();

        if(!empty($user)){
            if(!empty($user->image)){
                if(substr($user->image, 0, 4) === "user"){
                    $user->image = URL::to('uploads/users/'.$user->image);
                }
            }else{
                $user->image = URL::to('uploads/users/defaultLogo.jpg');
            }

            if(empty($user->api_token)){
                $user->api_token = $requestData['api_token'];
                $user->save();
            }

            $data['user'] = $user;
            return $data;
        }

        $validator = Validator::make($requestData,[
            'name'=>'required|max:100',
            'email'=>'required|unique:users,email|email|max:100',
            'image'=>'required|unique:users,image|max:500',
            'socialType'=>'required|in:face,google',
            'socialToken'=>'required|unique:users,socialToken|max:250',
        ]);
            

        if($validator->fails()) {
            $data['status'] = false;
            $err = $validator->errors()->toArray();
            $data['message'] = array_values($err)[0][0];
            return $data;
        }


        $requestData['password'] = Str::random(50);

        $user = User::where('deviceId',$device_id)->first();
        if (!empty($user)) {
            User::where('deviceId',$device_id)->update($requestData);
        }else{
            $requestData['deviceId'] = $device_id;
            $requestData['country'] = $country;
            $user = User::create($requestData);
        }
        $user->image = URL::to('uploads/users/defaultLogo.jpg');

        $data['user'] = $user;
        return $data;
    }




    public function login(Request $request){
        $user = User::where('email',$request->email)->first();

        if(!empty($user)) {
            if(Hash::check($request->password,$user->password)){
                $data['status'] = true;
                $data['user'] = $user;
                $data['user']->api_token = Str::random(50);
                $data['user']->save();

                if(!empty($data['user']->image)){
                    if(substr($data['user']->image, 0, 4) === "user"){
                        $data['user']->image = URL::to('uploads/users/'.$data['user']->image);
                    }
                }else{
                    $data['user']->image = URL::to('uploads/users/defaultLogo.jpg');
                }

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




    public function profile(Request $request){
        $data['status'] = true;
        $data['user'] = Auth::guard('api')->user();

        if(!empty($data['user']->image)){
            if(substr($data['user']->image, 0, 4) === "user"){
                $data['user']->image = URL::to('uploads/users/'.$data['user']->image);
            }
        }else{
            $data['user']->image = URL::to('uploads/users/defaultLogo.jpg');
        }

        return $data;
    }




    public function changePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'password' => 'required|max:100',
            'confirmPassword' => 'same:password',
        ]);

        if($validator->fails()) {
            $data['status'] = false;
            $err = $validator->errors()->toArray();
            $data['message'] = array_values($err)[0][0];
            return $data;
        }


        $password = Hash::make($request->password);
        $user = User::find(Auth::guard('api')->id());
        $user->password = $password;
        $user->save();

        $data['status'] = true;
        $data['message'] = 'password changed';

        return $data;
    }





    public function addNewAddress(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'phone' => 'required|max:15',
            'street' => 'required|max:100',
            'address' => 'required|max:200',
            'addressDESC' => 'required|max:200',
            'homeNumber' => 'required|max:100',
            'postalCode' => 'required|max:100',
            'lng' => 'required|max:100',
            'lat' => 'required|max:100',
            'isMain' => 'required|boolean',
        ]);

        if($validator->fails()) {
            $data['status'] = false;
            $err = $validator->errors()->toArray();
            $data['message'] = array_values($err)[0][0];
            return $data;
        }
        $data['status'] = true;
        $addressData = $request->all();
        $addressData['user_id'] = Auth::guard('api')->id();

        $userAddress = User_address::where([
            'user_id' => Auth::guard('api')->id(),'isMain'=>true
        ])->first();

        if(!empty($userAddress)){
            $userAddress->isMain = false;
            $userAddress->save();
        }
        
        
        if ($request->id == false) {
            User_address::create($addressData);
            $data['message'] = 'address added';
        }else{
            User_address::where('id',$request->id)->update($addressData);
            $data['message'] = 'address updated';
        }


        return $data;
    }





    public function getAddress(){
        $data['status'] = true;
        $data['address'] = User_address::where('user_id',Auth::guard('api')->id())->get();
        return $data;
    }




    public function deleteAddress(Request $request,$id){
        User_address::where(['id' => $id ,'user_id' => Auth::guard('api')->id()])->delete();
        $data['status'] = true;
        $data['message'] = 'address deleted';

        return $data;
    }




    public function updateProfile(Request $request){

        $user = Auth::guard("api")->user();
        
        $data = $request->except(['api_token']);
        $destinationPath = public_path('uploads/users/');
        $data['image'] = $user->image;

        $validator = Validator::make($request->all(),[
          'name' => 'required|max:100',
          'email' => 'required|unique:users,email,'.$user->id.'|max:100',
          'phone' => 'required|unique:users,phone,'.$user->id.'|max:100',
        ]);

        
        if($validator->fails()) {
            $data['status'] = false;
            $err = $validator->errors()->toArray();
            $data['message'] = array_values($err)[0][0];
            return $data;
        }


        if ($request->hasFile('image')) {
            File::delete($destinationPath.$data['image']);
            $image = $request->file('image');
            $data['image'] = "user".Str::random(30).'.'.$image->getClientOriginalExtension();
            $image->move($destinationPath, $data['image']);
        }

        User::where('id',$user->id)->update($data);

        $user = User::find($user->id);
        
        if(!empty($user->image)){
            if(substr($user->image, 0, 4) === "user"){
                $user->image = URL::to('uploads/users/'.$user->image);
            }
        }else{
            $user->image = URL::to('uploads/users/defaultLogo.jpg');
        }

        $info['status'] = true;
        $info['user'] = $user;

        return $info;
    }




    public function logOut(Request $request){
        User::where('id',Auth::guard('api')->id())->update(['api_token' => null]);
        $data['status'] = true;
        $data['message'] = "loged out";
        return $data;
    }




    public function postForgetPass(Request $request){

        $validator = Validator::make($request->all(),[
                    'email'=>'required|email|max:100',
                ]);
        
        if($validator->fails()) {
            $data['status'] = false;
            $err = $validator->errors()->toArray();
            $data['message'] = array_values($err)[0][0];
            return $data;
        }

        $user = User::where('email',$request->email)->first();
        if (!empty($user)) {
            $user->verify_token = Str::random(50);
            $user->save();

            \Mail::to($user->email)->send(new Forget_pass($user));
            $data['status'] = true;
            $data['message'] = "mailSent";
        }else{
            $data['status'] = false;
            $data['message'] = "Not found";
        }

        return $data;
    }









}
