@component('mail::message')
# {{$introduction}}

{{$message}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
