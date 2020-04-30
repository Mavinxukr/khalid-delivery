<?php


namespace App\Contracts\Client\Order;



use App\Contracts\FormatInterface;
use Illuminate\Http\Request;

interface PreOrderInterface extends FormatInterface
{
    public function store(Request $request);
}
