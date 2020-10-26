<?php


namespace App\Repositories\Client;


use App\Contracts\Client\Profile\RewardInterface;
use App\Helpers\TransJsonResponse;
use App\Mail\SendOrderMail;
use App\Models\Reward\Reward;
use App\Notifications\SendReward;
use App\User;
use Illuminate\Http\Request;
use Mail;

class RewardRepository implements RewardInterface
{
    public function sendReward(Request $request)
    {
        $valid = Reward::where([
            'recipient_email' => $request->email,
            'sender_id' => $request->user()->id
        ])->first();

        if (!is_null($valid)){
            return TransJsonResponse::toJson('Error',[],
                'You already send promo code to this user',400);
        }
        $reward = Reward::create([
            'sender_id' => $request->user()->id,
            'code'  => $request->user()->promo_code,
            'used' =>  0,
            'recipient_email' => $request->email
        ]);
        Mail::to($reward->recipient_email)->send(new SendOrderMail($reward));
        return TransJsonResponse::toJson('Success',[],
            'Promo code was send',200);

    }

    public function usingCode(Request  $request)
    {
        $sender =  User::where('promo_code',$request->get('code'))->first();
        if (is_null($sender)){
            return TransJsonResponse::toJson('Error',[],
                'Promo code is invalid',400);
        }
        Reward::updateOrCreate([
            'recipient_email' => $request->user()->email,
            'code'  => $request->get('code'),
            'sender_id' => $sender->id
        ],
            [
                'recipient_email' => $request->user()->email,
                'code'  => $request->get('code'),
                'sender_id' => $sender->id
            ]
        );

        $reward =  Reward::where([
            'code' => $request->get('code'),
            'recipient_email' => $request->user()->email
        ])->first();

        if (is_null($reward) ||$reward->sender_id === $request->user()->id  || $reward->used){
            return TransJsonResponse::toJson('Error',[],
                'Promo code is invalid or already used',400);
        }

        $rewardRecipient = User::whereEmail($reward->recipient_email)->first();
        if (is_null($rewardRecipient->creditCard)){
            return TransJsonResponse::toJson('Error',[],
                'You can use promo code because you do not have credit card in account',400);
        }

        $reward->used = true;
        $rewardRecipient->bonus += 10;
        $reward->sender->bonus += 10;
        $reward->save();
        $rewardRecipient->save();
        $reward->sender->save();
        return TransJsonResponse::toJson('Success',[],
            'Promo promo is activate - you will get 10$',200);

    }
}
