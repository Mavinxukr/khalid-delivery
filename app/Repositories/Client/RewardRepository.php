<?php


namespace App\Repositories\Client;


use App\Contracts\Client\Profile\RewardInterface;
use App\Helpers\TransJsonResponse;
use App\Models\Reward\Reward;
use App\Notifications\SendReward;
use Illuminate\Http\Request;

class RewardRepository implements RewardInterface
{
    public function sendReward(Request $request)
    {
        $validateRewardModel = Reward::where('email',$request->email)->first();

        if (!is_null($validateRewardModel)){
            return TransJsonResponse::toJson('Error',[],'You already send promo code this user',400);
        }

        $code = rand(10**5,10**6);
        $reward = Reward::create([
            'sender_id' => $request->user()->id,
            'email' => $request->email,
            'code'  => $code,
            'using' =>  0
        ]);

        $reward->notify(new SendReward($code,$request->user()));

    }
}
