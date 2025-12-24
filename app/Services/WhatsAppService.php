<?php

namespace App\Services;

use Twilio\Rest\Client;

class WhatsAppService
{
    public static function send(string $phone, string $message)
    {
        $sid   = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from  = config('services.twilio.from');

        $twilio = new Client($sid, $token);

        return $twilio->messages->create(
            'whatsapp:' . $phone,
            [
                'from' => $from,
                'body' => $message,
            ]
        );
    }
}
