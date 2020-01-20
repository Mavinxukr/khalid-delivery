<?php


namespace App\Contracts\Client\Order;


interface OrderFoodInterface
{
    public function show (int $id);

    public function store($data);

    public function confirmOrder($data);

    public function cancelOrder($data);

    public function restoreOrder(int $id);
}
