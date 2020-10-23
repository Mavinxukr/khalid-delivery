<?php


namespace App\Repositories\Client;


use App\Contracts\Client\Profile\RewardInterface;
use App\Helpers\TransJsonResponse;
use App\Models\Reward\Reward;
use App\Notifications\SendReward;
use App\User;
use Illuminate\Http\Request;

class RewardRepository implements RewardInterface
{
    public function sendReward(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        if(is_null($user)){
            return TransJsonResponse::toJson('Error',[],
                'This user is not found in app',400);
        }

        $reward = Reward::where([
            'recipient_id' => $user->id,
            'sender_id'  => $request->user()->id
        ])->first();
        if (!is_null($reward)  ){
            return TransJsonResponse::toJson('Error',[],
                'You already send promo code this user or this user is not found in app',400);
        }

        $code = rand(10**6,10**7);
        $reward = Reward::create([
            'sender_id' => $request->user()->id,
            'code'  => $code,
            'used' =>  0,
            'recipient_id' => $user->id
        ]);
        $reward->recipient->notify(new SendReward($code,$reward->sender));
        return TransJsonResponse::toJson('Success',[],
            'Promo code was send',200);

    }

    public function usingCode(Request  $request)
    {
        $reward =  Reward::where('code', $request->get('code'))->first();
        if (is_null($reward) ||$reward->sender_id === $request->user()->id  || $reward->used){
            return TransJsonResponse::toJson('Error',[],
                'Promo code is invalid or already used',400);
        }
        dd($reward);
        $reward->used = true;
        $reward->recipient->increment('bonus', 10);
        $reward->sender->increment('bonus', 10);
        $reward->save();
        return TransJsonResponse::toJson('Success',[],
            'Promo promo is activate - you will get 10$',200);

    }
}
