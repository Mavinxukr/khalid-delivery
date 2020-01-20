<?php


namespace App\Contracts\Client\Profile;


use App\User;

interface ProfileInterface
{
    public function update($data, int  $id);

    public function getUserByToken($data);

    public function getProfileComments(int $id);

}
