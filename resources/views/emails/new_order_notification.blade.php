<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>New Order Notification 🥰</h2>
<p>A new order has been submitted:</p>
<ul>
    <li>Provider: {{ $order->provider->name }}</li>
    <li>HMO: {{ $order->hmo->name }}</li>
    <li>Encounter Date: {{ $order->encounter_date }}</li>
    <li>Sent Date: {{ $order->sent_date }}</li>
</ul>
</body>
</html>
