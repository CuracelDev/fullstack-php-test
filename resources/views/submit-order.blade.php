@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <submit-order :hmos="{{json_encode($hmos)}}"></submit-order>
    </div>
</div>
@endsection
