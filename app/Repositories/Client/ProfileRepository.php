<?php


namespace App\Repositories\Client;


use App\Helpers\TransJsonResponse;
use App\Interfaces\Client\Profile\ProfileInterface;
use App\Interfaces\FormatInterface;
use App\Models\Feedback\Feedback;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileRepository implements ProfileInterface, FormatInterface
{
    public function update($data, int $id)
    {
        $user = User::findOrFail($id);
        $user->edit = true;
        $user->first_name = $data->first_name ?? $user->first_name;
        $user->last_name = $data->last_name ?? $user->last_name;
        $user->phone = $data->phone ?? $user->phone;
        $user->email = $data->email ?? $user->email;
            if (isset($data->password)){
                $user->password =   bcrypt($data->password);
            }
        $user->image = isset($data->image)? $this->updateImage($data->image, $user) : $user->image;
        $user->save();
        $result = $this->format($user);

        return TransJsonResponse::toJson(true, $result,'Updated user', 200);
    }

    public function getUserByToken($data)
    {
        $user =  $this->format($data->user());

        return TransJsonResponse::toJson(true, $user,'Get user', 200);

    }

    public function updateImage($file, User $user) :string
    {
        if (!is_null($file)){
            $ext = explode("/", $file->getClientMimeType());
            $name = Str::random('60').'.'.end($ext);
            $path = 'image/profile/'. $name;
            if (file_exists(storage_path('app/public/').$user->image)){
                Storage::disk('public')->delete($user->image);
            }
            Storage::disk('public')->put($path,file_get_contents($file));
            return  $path;
        }else{
            return $user->image;
        }

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
            'image'       => isset($data->image)
                            ?  env('APP_URL_IMAGE').$data->image : null,
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
