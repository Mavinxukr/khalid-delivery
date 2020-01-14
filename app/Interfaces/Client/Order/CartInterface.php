<?php


namespace App\Interfaces\Client\Order;


use Illuminate\Support\Facades\Request;

interface CartInterface
{
    public function index($data);

    public function store($data);

    public function update($data, int $id);

    public function delete(int $id);
}
