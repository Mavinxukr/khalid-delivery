<?php


namespace App\Contracts\Client\Profile;


use Illuminate\Http\Request;

interface RewardInterface
{
    public function sendReward(Request $request);
    public function usingCode(Request $request);
}
