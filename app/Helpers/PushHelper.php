<?php


namespace App\Helpers;


use App\Models\Devices\Device;
use Edujugon\PushNotification\PushNotification;

class PushHelper
{
    public static function sendPush(int $id, string $title):void
    {
        $devices = Device::where('user_id', $id)->get();

        if (count($devices)) {
            foreach ($devices as $device) {
                $push = new PushNotification($device->service);
                ($device->service == 'fcm') ?
                    $data = self::generateFCM($title) :
                        $data = self::generateAPN($title);

                $response = $push->setMessage($data)
                    ->setDevicesToken($device->token)
                    ->send()
                    ->getFeedback();
            }
        }
    }

    public static function generateFCM(string $title) : array
    {
        $data = [
            'data' => [
                'title' => $title,
                //'loc-args'  => [$subscriber, $ad]
            ]
        ];
        return $data;
    }

    public static function generateAPN(string $title): array
    {
        $data = [
            'aps' => [
                'alert' => [
                    'loc-key' => $title,
                    //'loc-args' => [$subscriber, $ad]
                ],
                'sound' => 'default',
            ]
        ];
        return $data;
    }
}
