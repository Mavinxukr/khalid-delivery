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
        'order'         => $order->id,
        'description'   => $order->product->title,
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
    <style>
        .border,
        .border-column td,
        .border-column th{
            border: 1px solid black;
        }
    </style>
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
                {{$orders->min('created_at')->format('d/m/Y')}} -
                {{$orders->max('created_at')->format('d/m/Y')}}</td>
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
        <tr><td>[Street Address]</td></tr>
        <tr><td>[City, State, Country]</td></tr>
        <tr><td>[ZIP Code]</td></tr>
        <tr><td width="100%" height="20">&nbsp;</td></tr>
        </tbody>
    </table>


    <table class="table" border="0" cellspacing="0" cellpadding="15">
        <thead>
        <tr class="border border-column">
            <th>Date&nbsp;of&nbsp;sale</th>
            <th>#&nbsp;Order</th>
            <th>Description</th>
            <th>Sales&nbsp;Amount</th>
            <th>Commission&nbsp;%</th>
            <th>Net&nbsp;Amount</th>
        </tr>
        </thead>
        <tbody>
            @foreach($ordersArray as $order)
                <tr class="border border-column">
                    <td>{{$order['date']}}</td>
                    <td>{{$order['order']}}</td>
                    <td>{{$order['description']}}</td>
                    <td>{{$order['price']}}</td>
                    <td>$ {{$order['commission']}}</td>
                    <td>$ {{$order['net_amount']}}</td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">SUBTOTAL</td>
                <td class="border">$ {{$subtotal}}</td>
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
