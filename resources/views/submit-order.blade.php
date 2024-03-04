@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- <submit-order></submit-order> --}}
        <example-component></example-component>
        {{-- <button-component></button-component> --}}
        {{ access_token()  }}
    </div>
</div>
@endsection
