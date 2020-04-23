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
            <td><b>{{$order->product->provider->name}}</b></td>
            <td>Invoice #</td>
            <td>Date</td>
        </tr>
        <tr>
            <td>{{$order->product->provider->email}}</td>
            <td>#</td>
            <td>22.04.20</td>
        </tr>
        <tr>
            <td>{{$order->product->provider->phone_number}}</td>
            <td>Period</td>
            <td>01/04/20 - 10/04/20</td>
        </tr>
        </tbody>
    </table>
    <table>
        <tbody>
        <tr><td width="100%" height="50">&nbsp;</td></tr>
        <tr><td><b>To Principal</b></td></tr>
        <tr><td></td></tr>
        <tr><td>{{$order->name}}.</td></tr>
        <tr><td>{{$order->place->address}}</td></tr>
        <tr><td>{{$order->place->city . ', ' . $order->place->country}}</td></tr>
        <tr><td>{{$order->place->postal_code}}</td></tr>
        <tr><td width="100%" height="20">&nbsp;</td></tr>
        </tbody>
    </table>


    <table class="table" border="1" cellspacing="0" cellpadding="15">
        <thead>
        <tr>
            <th>Date of sale</th>
            <th># Order</th>
            <th>Description</th>
            <th>Sales Amount</th>
            <th>Commission %</th>
            <th>Net Amount</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$order->created_at->format('d.m.Y')}}</td>
                <td>{{$order->id}}</td>
                <td>{{$order->product->title}}</td>
                @if($order->product->has_ingredients)
                    <td>{{$order->preOrder->price}}</td>
                @else
                    <td>{{$order->product->price}}</td>
                @endif
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
@endsection
