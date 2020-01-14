<?php


namespace App\Interfaces\Client\Profile;


use App\User;

interface ProfileInterface
{
    public function update($data, int  $id);

    public function getUserByToken($data);

    public function updateImage($file, User $user): string ;

    public function getProfileComments(int $id);

}
