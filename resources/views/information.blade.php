@extends('includes.header')
@section('body')


{{-- shelter information --}}

<div class="container d-flex bootstrap-grid mb-2 mt-2 mx-auto">

    <div class="card mb-3 col-lg-12 col-md-12 col-sm-12 mx-auto card-width">


        <img src="{{ route('getImage', ['imageName' => $result['Shelter Name']]) }}" class="card-img-top informationImages" alt="Shelter Image">

        <div class="card-body">
            <div class="text-center">
                <h5 class="card-title">{{ $result['Shelter Name'] }}</h5>
                <p class="card-text m-1">{{ $result['Location'] }}</p>
                <a class="card-text" href="tel:{{ $result['Contact Info'] }}"> {{ $result['Contact Info'] }}</a>
                <h5 class="card-text">Avalible Beds: {{ $result['Beds'] }}</h5>
                <p class="card-text"><small class="text-muted">Last Updated: {{ $result['Timestamp'] }}</small></p>
            </div>
            <hr />
            @foreach(array_slice($result, 6) as $key => $info)
            @if($info != 'No')
            <p class="card-text">{{ $key }}: {{ $info }}</p>
            @endif
            @endforeach
            <a class="btn btn-primary" href="{{ route('mapView', ['shelterRow' => $result['Row Number'], 'shelterName' => Str::slug($result['Shelter Name'], '-') ]) }}">Get Directions</a>
        </div>
    </div>
</div>

@endsection