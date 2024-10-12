<?php

namespace App\Notifications\Channels;

use Twilio\Rest\Client as TwilioClient;

class TwilioChannel
{
    protected $client;

    public function __construct(TwilioClient $client)
    {
        $this->client = $client;
    }

    public function send($notifiable, $notification)
    {
        $message = $notification->toTwilio($notifiable);

        $this->client->messages->create(
            $notifiable->routeNotificationFor('twilio'),
            [
                'from' => config('services.twilio.from'),
                'body' => $message->content,
            ]
        );
    }
}
