<?php


namespace App\Helpers;


class TransJsonResponse
{
    public static function toJson(bool $status, $data, string $message, int $code)
    {
        return response()->json([
            'status'    => $status,
            'message'   => $message,
            'data'      => $data
        ],$code);

    }
}
