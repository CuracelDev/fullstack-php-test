@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <submit-order :provider="'{{ Auth::user()->name }}'"></submit-order>
    </div>
</div>
@endsection
