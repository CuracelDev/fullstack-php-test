@component('mail::message')
    # Hello,

    An order with reference {{$order->reference}} has been made by {{ $order->provider_name }}. Please find below the details of the order.

    @component('mail::table')
        | Item Name | Unit Price | Quantity | Total Price |
        | --------- | ---------- | -------- | ----------- |
        @foreach ($order->items as $item)
            | {{ $item['item'] }} | ${{ $item['unit_price'] }} | {{ $item['quantity'] }} | ${{ $item['total_price'] }} |
        @endforeach
        | **Total** | | | ${{ $order->total_amount }} |
    @endcomponent

    Thanks,
    {{ config('app.name') }}
@endcomponent
