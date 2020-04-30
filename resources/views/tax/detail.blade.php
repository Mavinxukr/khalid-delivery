@extends('tax.layout')

@section('content')
    <h3 style="text-align: center">Tax Invoice</h3>

    <table>
        <tbody>
        <tr>
            <td>
                {{$order->product->provider->name}}. <br>
            </td>
        </tr>
        <tr><td width="100%" height="20">&nbsp;</td></tr>
        <tr><td><b>Invoice No: </b>{{$order->id}}</td></tr>
        <tr><td width="100%" height="20">&nbsp;</td></tr>
        <tr>
            <td>
                <b>Dated: </b>{{$order->created_at->format('d-M-Y')}}
            </td>
        </tr>
        @if($order->created_at != $order->date_delivery)
        <tr>
            <td>
                <b>Date of supply: </b>{{$order->date_delivery->format('d-M-Y')}}
            </td>
        </tr>
        @endif
        <tr><td width="100%" height="20">&nbsp;</td></tr>
        <tr><td><b>Buyer</b></td></tr>
        <tr><td></td></tr>
        <tr><td>{{$order->name}}.</td></tr>
        <tr><td>{{$order->place->address . ', ' . $order->place->city}}</td></tr>
        <tr><td>{{$order->place->country}}</td></tr>
        <tr><td width="100%" height="20">&nbsp;</td></tr>
        </tbody>
    </table>


    <table class="table" border="1" cellspacing="0" cellpadding="15">
        <thead>
        <tr>
            <th>{{$headers['description']}}</th>
            <th>{{$headers['quantity']}}</th>
            <th>{{$headers['rate']}}</th>
            <th>{{$headers['per']}}</th>
            <th>{{$headers['amount']}}</th>
            <th>{{$headers['discount']}}</th>
            <th>{{$headers['tax_value']}}</th>
            <th>{{$headers['vat']}}</th>
            <th>{{$headers['vat_amount']}}</th>
        </tr>
        </thead>
        <tbody>
        @if(!$order->product->has_ingredients)
            <tr>
                <td>{{$order->product->description}}</td>
                <td>{{$order->quantity}} nos</td>
                <td>{{$order->product->price}}</td>
                <td>nos</td>
                <td>{{$order->product->price * $order->quantity}}</td>
                <td></td>
                <td>{{$order->product->price * $order->quantity}}</td>
                <td>5%</td>
                <td>{{($order->product->price * $order->quantity) / 100 * 5}}</td>
            </tr>
            <tr>
                <td>VAT</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{($order->product->price * $order->quantity) / 100 * 5}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Total</b></td>
                <td>{{$order->quantity}} nos</td>
                <td></td>
                <td></td>
                <td>{{$order->cost}}</td>
                <td></td>
                <td>{{$order->product->price * $order->quantity}}</td>
                <td></td>
                <td>{{($order->product->price * $order->quantity) / 100 * 5}}</td>
            </tr>
        @else
            @foreach($order->preOrder->details as $item)
                <tr>
                    <td>{{$item->product->description}}</td>
                    <td>{{$item->count}} nos</td>
                    <td>{{$item->product->price}}</td>
                    <td>nos</td>
                    <td>{{$item->product->price * $item->count}}</td>
                    <td></td>
                    <td>{{$item->product->price * $item->count}}</td>
                    <td>5%</td>
                    <td>{{($item->product->price * $item->count) / 100 * 5}}</td>
                </tr>
            @endforeach
            <tr>
                <td>VAT</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{$order->preOrder->price / 100 * 5}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Total</b></td>
                <td>{{$order->preOrder->details->sum('count')}} nos</td>
                <td></td>
                <td></td>
                <td>{{$order->cost}}</td>
                <td></td>
                <td>{{$order->preOrder->price}}</td>
                <td></td>
                <td>{{$order->preOrder->price / 100 * 5}}</td>
            </tr>
        @endif
        </tbody>
    </table>
    <table width="100%" style="text-align: right">
        <tbody>
        <tr>
            <td width="100%" height="44">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <b>for {{$order->product->provider->name}}.</b>
            </td>
        </tr>
        <tr>
            <td>
                Authorised Signature
            </td>
        </tr>
        </tbody>
    </table>
@endsection
