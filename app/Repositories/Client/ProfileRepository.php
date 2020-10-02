<?php


namespace App\Repositories\Client;


use App\Helpers\ActionSaveImage;
use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Profile\ProfileInterface;
use App\Contracts\FormatInterface;
use App\User;
use Carbon\Carbon;

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
            'orders'            => $data->orderProfile()->get()->map(function ($i){
                                            return [
                                                'id'                    => $i->id,
                                                'provider_name'         => $i->provider->name ?? '',
                                                'provider_category'     => $i->provider_category,
                                                'date_delivery'         => $i->date_delivery->toDateString(),
                                                'date_delivery_from'    => $i->date_delivery_from,
                                                'date_delivery_to'      => $i->date_delivery_to,
                                                'callback_time'         => $i->callback_time,
                                                'cost'                  => $i->cost,
                                                'status'                => $i->status,
                                                'delivery_status'=> !is_null($i->delivery_status) ? [
                                                    'status' => $i->delivery_status->name,
                                                    'step'   => $i->delivery_status->step,
                                                ] : null,
                                                'place'                 => $i->place,
                                                'comment'               => $i->comment,
                                                'extends'       => $i->extends->map(function($i){
                                                    $fromH = Carbon::make($i->extend_from)->hour;
                                                    $fromM = Carbon::make($i->extend_from)->minute;
                                                    $toH = Carbon::make($i->extend_to)->hour;
                                                    $toM = Carbon::make($i->extend_to)->minute;
                                                    $hours = $toH - $fromH ;
                                                    $minutes = $toM - $fromM;
                                                    $text = '+';
                                                    if ($hours > 0){
                                                        $hours .= ' hours';
                                                        $text .= $hours;
                                                    }
                                                    if ($minutes > 0){
                                                        $minutes .= ' minutes';
                                                        $text .= ' '.$minutes;
                                                    }

                                                    $text .= ', +'. $i->cost.'$';

                                                    return [
                                                        'id'    => $i->id,
                                                        'extend_to' => $i->extend_to,
                                                        'extend_from' => $i->extend_from,
                                                        'cost'  => $i->cost,
                                                        'status'    => $i->accepted,
                                                        'text'      => $text
                                                    ];
                                                })

                                            ];
                                    })
        ];
        return $result;
    }
}
