<?php


namespace App\Contracts\Client\Product;


interface FilterInterface
{
    public function getKitchen();

    public function getByFilters($data);
}
