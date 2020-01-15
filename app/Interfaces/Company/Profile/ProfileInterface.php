<?php


namespace App\Interfaces\Company\Profile;


use App\Interfaces\FormatInterface;
use App\User;
use Illuminate\Http\Request;

interface ProfileInterface
{
    public function getCompanyProfile(User $data);

    public function updateCompanyProfile(Request $request);

    public function updateLanguage(string $ids);

    public function getLanguage();
}
