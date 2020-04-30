<?php

namespace App\Http\Controllers\Api;

use App\Helpers\TransJsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Devices\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * @api {post} client/devise  Add User device
     * @apiName  Add User device
     * @apiVersion 1.1.1
     * @apiGroup Client  Auth
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiParam {String} token Token user device
     * @apiParam {String} service Push Service (for Android send: fcm, for IOS send: apn)
     * @apiSampleRequest  client/devise
     */
    public function addDeviceToken(Request $request)
    {
        $user = $request->user();
        Device::updateOrCreate(
            [
                'token'   => $request->token,
                'user_id' => $user->id
            ],
            [
                'service' => $request->service,
            ]
        );
        return TransJsonResponse::toJson(true,null,'Ok', 200);
    }
}
