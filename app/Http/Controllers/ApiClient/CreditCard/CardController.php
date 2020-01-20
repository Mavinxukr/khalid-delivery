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

    public function index()
    {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CreditCard\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CreditCard\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CreditCard\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CreditCard\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }

    public function checkout()
    {
        return view('payment.checkout');
    }

    public function callbackCheckout(Request $request)
    {
        dd($request);
    }
}
