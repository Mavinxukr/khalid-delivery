<?php


namespace App\Contracts\Company\Profile;


use App\Contracts\FormatInterface;
use App\Models\Provider\Provider;
use App\User;
use Illuminate\Http\Request;

interface ProfileInterface extends FormatInterface
{
    public function getCompanyProfile(User $data);

    public function updateCompanyProfile(Request $request);

    public function getLanguage();

    public function updateLanguage(Provider $provider,string $ids);

    public function getSchedule(Request $request);

    public function updateSchedule(Request $request);

    public function getCreditCard(Request $request);

    public function updateCreditCard(Request $request);

}
