<?php


namespace App\Contracts\Client\Order;


use App\Contracts\FormatInterface;

interface OrderServiceInterface extends FormatInterface
{
    public function store($data);

    public function show(int $id);

    public function confirmOrder($data);

    public function cancelOrder($data);

    public function restoreOrder(int $id);
}
