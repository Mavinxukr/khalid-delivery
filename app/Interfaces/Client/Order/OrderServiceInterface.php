<?php


namespace App\Interfaces\Client\Order;


interface OrderServiceInterface
{
    public function store($data);

    public function show(int $id);

    public function confirmOrder($data);

    public function cancelOrder($data);

    public function restoreOrder(int $id);
}
