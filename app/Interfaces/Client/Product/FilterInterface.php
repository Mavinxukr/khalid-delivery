<?php


namespace App\Interfaces\Client\Product;


interface FilterInterface
{
    public function getKitchen();

    public function getByFilters($data);
}
