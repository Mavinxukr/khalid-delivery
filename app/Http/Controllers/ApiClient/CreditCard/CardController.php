<?php

namespace App\Http\Controllers\ApiClient\CreditCard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreditCardRequest;
use App\Contracts\Client\CreditCard\CreditCardInterface;
use App\Models\CreditCard\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    private $card;

    public function __construct(CreditCardInterface $card)
    {
        $this->card = $card;
    }

    /**
     * @api {post} client/cards  Store  card  #Screen №6, 21
     * @apiName  Store  card
     * @apiVersion 1.1.1
     * @apiGroup Client Card
     * @apiParam {String} holder_name Card holder name
     * @apiParam {String} number_card Card number
     * @apiParam {String} expire_month Expire month (format -10)
     * @apiParam {String} expire_year Expire year (format - 22)
     * @apiParam {String} cvv_code Cvv code (format - 123)
     * @apiParam {String} zip_code Zip code (format 10101)
     * @apiPermission Authorization
     * @apiHeader  Authorization token
     * @apiSampleRequest  client/cards
     */

    public function store(CreditCardRequest $request)
    {
        return $this->card->store($request);
    }

}
