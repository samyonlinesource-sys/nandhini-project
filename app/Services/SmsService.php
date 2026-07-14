<?php

namespace App\Services;
use Twilio\Rest\Client;

class SmsService
{
    /**
     * Create a new class instance.
     */
    protected Client $client;
    public function __construct()
    {
        $this->client=new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }
    // public function send_sms($mobile,$otp){
    // try{
    //     $message=$this->client->message->create($mobile,['from'=>env('TWILIO_PHONE'),'body'=>"Your OTP is {$otp}"]);
    //     return['status'=>true, 'sid'=>$message->sid, 'body'=>$message->body];
    //  }
    //  catch(\Exception $e){
    //            return['status'=>false, 'error'=>$e->getMessage()];
    //  }
    // }

    public function send_sms($mobile, $otp)
    {
        try {

            $message = $this->client->messages->create(
                $mobile, // Example: +919876543210
                [
                    'from' => env('TWILIO_PHONE'),
                    'body' => "Your OTP is {$otp}. Do not share it with anyone.",
                ]
            );

            return [
                'status' => 200,
                'sid'    => $message->sid,
                'body'   => $message->body,
            ];

        } catch (\Exception $e) {

            return [
                'status' => 400,
                'error'  => $e->getMessage(),
            ];
        }
    }
}
