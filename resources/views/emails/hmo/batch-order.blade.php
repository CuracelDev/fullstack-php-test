@component('mail::message')
# You orders have been processed

Your orders have been processed. You can view the processed orders below.

@component('mail::button', ['url' => $orderUrl])
View Orders
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
