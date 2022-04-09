<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['title_ar', 'body_ar', 'model_type', 'user_id', 'model_id'];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function send($tokens, $title="hello", $msg="helo msg", $type="Other",$data=null){
        $key = 'AAAAoygP5GI:APA91bEq1bgtZ1S2j3tib1kGHdvwsWVfhUT381w7_nKP-HDx99PJPKjetMzNx_2bD4q4NT_PD9qQGvjJHIsDPZ0GHaHZLWzaqFt9Yp83-xXKtTSoRRxCsg-0lqewmlLF0eTb5V5SHfAq';

        $fields = array
        (
//            "registration_ids" => (array)$tokens,
            "registration_ids" => (array)$tokens,
            //"registration_ids" => (array)'diLndYfZRFyxw8nOjU5yt0:APA91bGYE5TyP2VjgUHHEuCP5-dMEoY8K4AgEl_JuWYjcFyJxS1MamBtJhmp4y-q-lhYWF6AXvy9OpgOJJsJyJ5qSNCHFvSR3iWODWVb84NkbnpZYcuNL0mkforreA89wcwrHuntJdaG',
            "priority" => 10,
            'data' => [
                'title' => $title,
                'body' => $msg,
                'type' => $type,
                'model_id' => isset($data->model_id) ? $data->model_id : "",
//                'not' => $not,
                'icon' => 'myIcon',
                'sound' => 'mySound',
            ],
            'notification' => [
                'title' => $title,
                'body' => $msg,
                'type' => $type,
                'model_id' => isset($data->model_id) ? $data->model_id : "",
//                'not' => $not,
                'icon' => 'myIcon',
                'sound' => 'mySound',
            ],
            'vibrate' => 1,
            'sound' => 1
        );

        $headers = array
        (
            'accept: application/json',
            'Content-Type: application/json',
            'Authorization: key=' . $key
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
//        dd($result);
        //  var_dump($result);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        return $result;
    }

}
