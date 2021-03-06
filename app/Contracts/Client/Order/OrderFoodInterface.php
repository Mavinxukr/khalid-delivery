<?php


namespace App\Contracts\Client\Order;


use App\Contracts\FormatInterface;

interface OrderFoodInterface extends FormatInterface
{
    public function show (int $id);

    public function store($data);

    public function confirmOrder($data);

    public function doneOrder($data);

    public function cancelOrder($data);

    public function restoreOrder(int $id);

    public function paidOrder($data);
}
