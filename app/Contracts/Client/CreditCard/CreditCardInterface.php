<?php


namespace App\Contracts\Client\CreditCard;


use App\Contracts\FormatInterface;

interface CreditCardInterface extends FormatInterface
{
    public function store($data);

}
