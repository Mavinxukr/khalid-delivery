<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #000;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .container {
                border: 1px solid black;
            }

            .info {
                font-size: 20px;
                text-align: left;
                margin-left: 20px;
            }

            .table {
                width: 100%;
            }

            .signature {
                font-size: 20px;
                text-align: right;
                margin-right: 20px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="container">
                    <h3>Tax Invoice</h3>

                    <div class="info">
                        {{$order->product->provider->name}}. <br>

                        <br>

                        <b>Dated: </b>{{$order->created_at->format('d-M-Y')}} <br>
                    </div>

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
                                    <td> </td>
                                    <td>{{$order->product->price * $order->quantity}}</td>
                                    <td>5%</td>
                                    <td>{{($order->product->price * $order->quantity) / 100 * 5}}</td>
                                </tr>
                                <tr>
                                    <td>VAT</td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td>{{($order->product->price * $order->quantity) / 100 * 5}}</td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td><b>Total</b></td>
                                    <td>{{$order->quantity}} nos</td>
                                    <td> </td>
                                    <td> </td>
                                    <td>{{$order->cost}}</td>
                                    <td> </td>
                                    <td>{{$order->product->price * $order->quantity}}</td>
                                    <td> </td>
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
                                        <td> </td>
                                        <td>{{$item->product->price * $item->count}}</td>
                                        <td>5%</td>
                                        <td>{{($item->product->price * $item->count) / 100 * 5}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>VAT</td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td>{{$order->preOrder->price / 100 * 5}}</td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td><b>Total</b></td>
                                    <td>{{$order->preOrder->details->sum('count')}} nos</td>
                                    <td> </td>
                                    <td> </td>
                                    <td>{{$order->cost}}</td>
                                    <td> </td>
                                    <td>{{$order->preOrder->price}}</td>
                                    <td> </td>
                                    <td>{{$order->preOrder->price / 100 * 5}}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <br>
                    <div class="signature">
                        <b>for {{$order->product->provider->name}}.</b> <br>
                        Authorised Signature
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
