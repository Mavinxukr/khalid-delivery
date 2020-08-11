<?php
$subtotal = 0;
foreach ($orders as $order){
    $subtotal += $order->debt;
}
?>

@extends('tax.layout')

@section('content')
    <h3 style="text-align: right">COMMISSION INVOICE</h3>

    <p>Hello, our company has not yet paid you for completed orders. Expect payment within a week</p>

    <table class="table" border="0" cellspacing="0" cellpadding="15">
        <thead>
        <tr style="border: 1px solid black">
            <th style="border: 1px solid black">#&nbsp;Order</th>
            <th style="border: 1px solid black">Debt</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr style="border: 1px solid black">
                <td style="border: 1px solid black">{{$order->id}}</td>
                <td style="border: 1px solid black">{{$order->debt}}</td>
            </tr>
        @endforeach
        <tr>
            <td align="right">TOTAL</td>
            <td style="border: 1px solid black">$ {{$subtotal}}</td>
        </tr>
        </tbody>
    </table>
@endsection

