<?php


namespace App\Repositories\Client;


use App\Helpers\ActionSaveImage;
use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Interfaces\Client\Profile\ProfileInterface;
use App\Interfaces\FormatInterface;
use App\User;

class ProfileRepository implements ProfileInterface, FormatInterface
{
    public function update($data, int $id)
    {
        $user = User::findOrFail($id);
        $user->edit = true;
        $user->first_name       = $data->first_name ?? $user->first_name;
        $user->last_name        = $data->last_name  ?? $user->last_name;
        $user->phone            = $data->phone      ?? $user->phone;
        $user->email            = $data->email      ?? $user->email;
        if (isset($data->password)){
            $user->password     = bcrypt($data->password);
        }
        $user->image            = isset($data->image) ?
                                  ActionSaveImage::updateImage($data->image, $user,'profile') :
                                  $user->image;
        $user->save();
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
            'id'          => $data->id,
            'first_name'  => $data->first_name,
            'last_name'   => $data->last_name,
            'email'       => $data->email,
            'image'       => ImageLinker::linker($data->image),
            'phone'       => $data->phone,
            'has_card'    => $hasCard
      ];

      if (!empty($data->myFeedback)){
          $result['feedbacks'] = $data->myFeedback()
                                ->get();
      }

      if (!empty($data->order)){
          $result['orders'] = $data->orderProfile()
                                ->get();
      }

      return $result;

    }



}
