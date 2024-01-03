<html>
<head>
    <title>New Order from {{ $order->provider_name }} </title>
</head>

<body>
    <h1 style="text-align:center; margin:50px 0px">New Order</h1><br>
    <div style="margin:0px 30px">
        <p><b>Hello {{ $order->hmo->name }},</b></p>
        <br>
        <p>A new order has been submitted by {{ $order->provider_name }}.</p>
        <p>Batch Identifier: <b>{{ $order->batch_identifier }}.</b></p>
        <br>
        <p>------------</p>
        <p>Regards,</p>
        <p>Curacel</p>
    </div>
</body>
</html>