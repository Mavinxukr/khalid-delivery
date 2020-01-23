<?php


namespace App\Contracts\Client\Order;



use App\Contracts\FormatInterface;
use Illuminate\Http\Request;

interface CartInterface extends FormatInterface
{
    public function index($data);

    public function store($data);

    public function update(Request $request, int $id);

    public function delete(int $id);
}
