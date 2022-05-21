@extends('layouts.app')

    @section('content')
        <batch-order id="{{$id}}" batch-type="{{$batch_type}}" />
    @endsection