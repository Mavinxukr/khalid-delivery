<?php


namespace App\Contracts\Client\Product;


use App\Contracts\FormatInterface;

interface FilterInterface extends FormatInterface
{
    public function getKitchen();
    public function getRatings(string  $type);
    public function getPrices(string  $type);
    public function getByFilters($data);
}
