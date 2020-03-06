<?php


namespace App\Contracts\Company\Order;


use App\Contracts\FormatInterface;
use Illuminate\Http\Request;

interface ServiceOrderInterface extends FormatInterface
{
    public function getAllOrder(Request $request);

    public function getAllOrderNoGeo(Request $request);

    public function getOneOrder(Request $request, int $id);

    public function getAllOrderByFilters(Request $request);
}
