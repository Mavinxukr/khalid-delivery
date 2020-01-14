<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>
</head>
<body>
<script id="widget-wfp-script" language="javascript" type="text/javascript" src="https://secure.wayforpay.com/server/pay-widget.js"></script>
<script type="text/javascript">
    var wayforpay = new Wayforpay();
    var pay = function () {
        wayforpay.run({
                merchantAccount : "test_merch_n1",
                merchantDomainName : "www.market.ua",
                authorizationType : "SimpleSignature",
                merchantSignature : "b95932786cbe243a76b014846b63fe92",
                orderReference : "DH783023",
                orderDate : "1415379863",
                amount : "1547.36",
                currency : "UAH",
                productName : "Процессор Intel Core i5-4670 3.4GHz",
                productPrice : "1000",
                productCount : "1",
                clientFirstName : "Вася",
                clientLastName : "Васечкин",
                clientEmail : "some@mail.com",
                clientPhone: "380631234567",
                language: "UA"
            },
            function (response) {
                // on approved
            },
            function (response) {
                // on declined
            },
            function (response) {
                // on pending or in processing
            }
        );
    }
</script>


<button type="button" onclick="pay();">Оплатить</button>
</body>
</html>
