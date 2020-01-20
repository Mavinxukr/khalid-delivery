<?php


namespace App\Repositories\Client;


use App\Helpers\TransJsonResponse;
use App\Contracts\Client\CreditCard\CreditCardInterface;
use App\Contracts\FormatInterface;
use App\Models\CreditCard\Card;
use Illuminate\Support\Facades\Auth;

class CreditCardRepository implements CreditCardInterface,FormatInterface
{

    public function store($data)
    {
        $card = Card::create($data->all() +
        [
            'user_id' => $data->user()->id
        ]);

        $result = $this->format($card);
        return TransJsonResponse::toJson(true,$result,'Card was added', 201);
    }

    public function format($data)
    {
        return [
            'card_holder'  => $data->holder_name,
            'number_card'  => $data->number_card
        ];
    }
}
