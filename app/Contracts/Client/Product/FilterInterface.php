<?php


namespace App\Contracts\Client\Product;


use App\Contracts\FormatInterface;

interface FilterInterface extends FormatInterface
{
    public function getKitchen();
    public function getRatingsPrices();
    public function getByFilters($data);
}
