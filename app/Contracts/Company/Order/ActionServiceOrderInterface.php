<?php


namespace App\Contracts\Company\Order;

use App\Contracts\FormatInterface;
use Illuminate\Http\Request;

interface ActionServiceOrderInterface extends  FormatInterface
{
    public function take(Request $request);

    public function cancel(Request $request, int $id);

    public function doneServiceOrder(Request $request);

    public function sendMyLocation(Request $request, int $id);

    public function extendServiceOrder(Request $request, int $id);
}
