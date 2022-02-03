<?php

namespace App\Helpers;
use App\Models\User_item_rate_comment;

use App\Models\Notifii;


class Helper{




    public static function senNotifi($data){

       

        //define( 'API_ACCESS_KEY', 'AAAADgcuByQ:APA91bE0sJahFFZ-EmO9h5PNLh4XzITFqCYAqHStUzQRHkMp5cHcne-V4tAkkKXQiE4EkVhHXqSNPTfdEodZMdHXZqTsD2Q_nY4T0kphE_wo5FJHQIEQx5ARqoZ4q4SKpf92Jo4iaIqn' );
        $API_ACCESS_KEY = 'AAAAgIegSOs:APA91bFAkXUMdf1dr_D1HtWJHLsZO1sOHdmiVutEGvDTUKZ2nB92MXsuoOOx8TJdLoiyaXhUbP_RFLs3MALuEYkLnJ9D1yMmtBXl9Vuyr2pp9MN3UJqMgS-TcAxd1S-eLqJwPNUEdKYJ';

        $users = isset($data['users'])?$data['users']:null;//array
        $title = isset($data['title'])?$data['title']:null;//single value
        $body = isset($data['body'])?$data['body']:null;//single value
        $from = isset($data['from'])?$data['from']:null;//single Value
        $type = isset($data['type'])?$data['type']:null;//[primaryUserApprove,acceptShipping,operationDone,inShipping,canceled,delivered]
        $type_id = isset($data['type_id'])?$data['type_id']:null;//single value

        if (!empty($users)) {

            foreach ( $users as $user ){
                   
                    Notifii::create([
                        'title'=>$title,
                        'body'=>$body,
                        'image'=>\URL::to('uploads/users/defaultLogo.jpeg'),
                        'type'=>$type,//[order,product,user]
                        'type_id'=>$type_id,//[order_id,product_id,user_id]
                        'user_id' => $user->id,
                    ]);

                    $registrationIds =  $user->firebase_token;

                    $msg = [
                        'title'=>$title,
                        'body'=>$body,
                        'image'=>\URL::to('uploads/users/defaultLogo.jpeg'),
                        'type'=>$type,//[primaryUserApprove,acceptShipping,operationDone,inShipping,canceled,delivered]
                        'type_id'=>$type_id,//product or shipping or order or else

                        'priority'=> 'high',
                        'icon'=> 'myicon',
                        'sound' => 'mySound'
                    ];

                    $fields = [
                        'to'=> $registrationIds,
                        'notification' => $msg,
                        "data " => [
                            "sound"=> "default",
                            "click_action"=>"FLUTTER_NOTIFICATION_CLICK",
                            "notification_foreground"=>"true",
                            "notification_android_sound"=>"default"
                        ]
                    ];
                
                    $headers = [

                        'Authorization: key=' . $API_ACCESS_KEY,
                        'Content-Type: application/json'
                    ];

                    #Send Reponse To FireBase Server    
                    $ch = curl_init();
                    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                    curl_setopt( $ch,CURLOPT_POST, true );
                    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                    $result = curl_exec($ch );
                    curl_close( $ch );
            }
   
        }
    }














}