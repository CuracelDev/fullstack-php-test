@component('mail::message')
    # Your Batch of orders for {{$batchName}} has been processed

    Thanks,
    {{ config('app.name') }}
@endcomponent
