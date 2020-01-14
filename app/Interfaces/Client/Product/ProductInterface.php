<?php


namespace App\Interfaces\Client\Product;


interface ProductInterface
{
    public function indexServices(string $type);
    public function show(int $id);
    public function showByCategory(int $provider_id,int $category_id);
    public function showServiceCategory(int $provider_id);

}
