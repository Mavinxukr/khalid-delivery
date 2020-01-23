<?php


namespace App\Repositories\Client;


use App\Helpers\ActionSaveImage;
use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Profile\ProfileInterface;
use App\Contracts\FormatInterface;
use App\User;

class ProfileRepository implements ProfileInterface
{
    public function update($data, int $id)
    {
        $user = User::findOrFail($id);
        $createData['edit'] = true;
        if(isset($data->password)) $createData['password'] = bcrypt($data->password);
        if (isset($data->image))   $createData['image']    =
                                    ActionSaveImage::updateOrCreateImage($data->image,$user,'profile');
        $user->update(array_filter(
            $data->except('image','password')) + $createData
        );
        $result = $this->format($user);
        return TransJsonResponse::toJson(true, $result,'Updated user', 200);
    }

    public function getUserByToken($data)
    {
        $user =  $this->format($data->user());

        return TransJsonResponse::toJson(true, $user,'Get user', 200);

    }
    public function getProfileComments(int $id)
    {
        $userComments = User::findOrFail($id);

        return TransJsonResponse::toJson(true, $this->format($userComments),
                                                        'Get user comments and orders', 200);
    }

    public function format($data)
    {
        $hasCard = true ? !is_null($data->creditCard) : false;
        $result =  [
            'id'                => $data->id,
            'first_name'        => $data->first_name,
            'last_name'         => $data->last_name,
            'email'             => $data->email,
            'image'             => ImageLinker::linker($data->image),
            'phone'             => $data->phone,
            'has_card'          => $hasCard,
            'feedbacks'         => $data->myFeedback()->get(),
            'orders'            => $data->orderProfile()->get(),
        ];
        return $result;
    }
}
