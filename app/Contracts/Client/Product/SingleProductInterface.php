<?php


namespace App\Contracts\Client\Product;


use App\Contracts\FormatInterface;

interface SingleProductInterface extends FormatInterface
{
    public function show(int $id);
}
