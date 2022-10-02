@extends('includes.header')
@section('body')

@foreach($result as $key => $info)
    <p>{{ $key }} ---> {{ $info }}</p>
@endforeach


@endsection