<?php

namespace App\Http\Controllers\Web\Reward;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function successReward(int $sender_id, string $email)
    {
       $str =  'User '. User::findOrFail($sender_id)->first_name. '</br>' ;
       $str .= 'Invites user '. $email;
       echo $str;
    }
}
