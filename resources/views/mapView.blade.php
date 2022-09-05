@extends('includes.header')
<script src='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css' rel='stylesheet' />

@section('body')
<div id="map"></div>



<script src="{{asset('js/mapbox/display.js')}}"></script>
@endsection