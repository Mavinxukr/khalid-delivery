<?php
$ordersArray = null;
$subtotal = 0;
$received = \App\Traits\FeeTrait::getFeeStatic($orders->first()->provider_category, 'received');
$vatValue = \App\Traits\FeeTrait::getFeeStatic($orders->first()->provider_category, 'vat');

foreach ($orders as $order){
    $price = $order->initial_cost;

    $commission = $price / 100 * (100 - $received);
    $netAmount = $price / 100 * $received;

    $ordersArray[] = [
        'date'          => $order->created_at->format('d.m.Y'),
        'date_pay'      => \Carbon::now()->format('d.m.Y'),
        'date_order'    => $order->date_delivery->format('d.m.Y'),
        'date_sale'     => $order->created_at->format('d.m.Y'),
        'order'         => $order->id,
        'description'   => $order->product->title ?? '',
        'price'         => $price,
        'commission'    => $commission,
        'net_amount'    => $netAmount,
    ];

    $subtotal = $subtotal + $netAmount;
}

$vat = $subtotal /100 * $vatValue;
$total = $subtotal + $vat;
$advanced = 0;
$amount = $total - $advanced;
?>

@extends('tax.layout')

@section('content')
    <h3 style="text-align: right">COMMISSION INVOICE</h3>

    <table>
        <tbody>
        <tr>
            <td>
                <b>Commission Agent</b>
            </td>
        </tr>
        <tr><td width="100%" height="10">&nbsp;</td></tr>
        </tbody>
    </table>
    <table width="100%">
        <tbody>
        <tr>
            <td><b>[Company Name]</b></td>
            <td align="center">Invoice #</td>
            <td align="center">Date</td>
        </tr>
        <tr>
            <td>[Street Address]</td>
            <td align="center">#</td>
            <td align="center">{{\Carbon\Carbon::now()->format('d.m.Y')}}</td>
        </tr>
        <tr>
            <td>[City, State, Country]</td>
            <td align="center">Period</td>
            <td align="center">
            @if($orders->count() > 1)
                {{$orders->min('created_at')->format('d/m/Y')}} -
                {{$orders->max('created_at')->format('d/m/Y')}}
            @else
                {{$orders->first()->created_at->format('d/m/Y')}}
            @endif
            </td>
        </tr>
        <tr>
            <td>[ZIP Code]</td>
            <td></td>
            <td></td>
        </tr>
        <tr><td height="10">&nbsp;</td></tr>
        <tr>
            <td>[E-mail]</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>[Phone]</td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
    <table>
        <tbody>
        <tr><td width="100%" height="50">&nbsp;</td></tr>
        <tr><td><b>To Principal</b></td></tr>
        <tr><td></td></tr>
        <tr><td>{{$provider->name}}</td></tr>
        @if(!is_null($provider->street_address))
            <tr><td>{{$provider->street_address}}</td></tr>
        @endif
        @if(!is_null($provider->city) || !is_null($provider->state) || !is_null($provider->country))
        <tr><td>
                @if(!is_null($provider->city))
                    {{$provider->city}},
                @endif
                @if(!is_null($provider->state))
                    {{$provider->state}},
                @endif
                @if(!is_null($provider->country))
                    {{$provider->country}}
                @endif
        </td></tr>
        @endif
        @if(!is_null($provider->zip))
            <tr><td>{{$provider->zip}}</td></tr>
        @endif
        <tr><td width="100%" height="20">&nbsp;</td></tr>
        </tbody>
    </table>


    <table class="table" border="0" cellspacing="0" cellpadding="15">
        <thead>
        <tr style="border: 1px solid black">
            <th style="border: 1px solid black">Date&nbsp;sale</th>
            <th style="border: 1px solid black">Date&nbsp;pay</th>
            <th style="border: 1px solid black">Date&nbsp;order</th>
            <th style="border: 1px solid black">#&nbsp;Order</th>
            <th style="border: 1px solid black">Description</th>
            <th style="border: 1px solid black">Sales&nbsp;Amount</th>
            <th style="border: 1px solid black">Commission&nbsp;%</th>
            <th style="border: 1px solid black">Net&nbsp;Amount</th>
        </tr>
        </thead>
        <tbody>
            @foreach($ordersArray as $order)
                <tr style="border: 1px solid black">
                    <td style="border: 1px solid black">{{$order['date']}}</td>
                    <td style="border: 1px solid black">{{$order['date_pay']}}</td>
                    <td style="border: 1px solid black">{{$order['date_order']}}</td>
                    <td style="border: 1px solid black">{{$order['order']}}</td>
                    <td style="border: 1px solid black">{{$order['description']}}</td>
                    <td style="border: 1px solid black">{{$order['price']}}</td>
                    <td style="border: 1px solid black">$ {{$order['commission']}}</td>
                    <td style="border: 1px solid black">$ {{$order['net_amount']}}</td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">SUBTOTAL</td>
                <td style="border: 1px solid black">$ {{$subtotal}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">VAT</td>
                <td>$ {{$vat}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">TOTAL</td>
                <td>$ {{$total}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">Advance payments received</td>
                <td>$ {{$advanced}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">Amount due to Principal</td>
                <td>$ {{$amount}}</td>
            </tr>
        </tbody>
    </table>
@endsection
