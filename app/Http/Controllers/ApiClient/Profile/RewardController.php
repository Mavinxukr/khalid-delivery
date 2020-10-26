<?php

namespace App\Http\Controllers\ApiClient\Profile;

use App\Contracts\Client\Profile\ProfileInterface;
use App\Contracts\Client\Profile\RewardInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    private $reward;

    public function __construct(RewardInterface $reward)
    {
        $this->reward = $reward;
    }


    /**
     * @api {post} client/reward Send reward
     * @apiName  Send reward
     * @apiVersion 1.1.1
     * @apiGroup Reward
     * @apiParam {String} email Email
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/reward
     */

    public function sendReward(Request  $request)
    {
        return $this->reward->sendReward($request);
    }


    /**
     * @api {post} client/reward/using Using reward
     * @apiName  Using reward
     * @apiVersion 1.1.1
     * @apiGroup Reward
     * @apiParam {Number} code Code
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/reward/using
     */

    public function usingCode(Request  $request)
    {
        return $this->reward->usingCode($request);
    }

}
