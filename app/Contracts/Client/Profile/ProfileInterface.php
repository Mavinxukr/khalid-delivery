<?php


namespace App\Contracts\Client\Profile;


use App\Contracts\FormatInterface;
use App\User;

interface ProfileInterface extends FormatInterface
{
    public function update($data, int  $id);

    public function getUserByToken($data);

    public function getProfileComments(int $id);

}
