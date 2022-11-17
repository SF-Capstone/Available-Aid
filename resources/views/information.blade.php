@extends('includes.header')
@section('body')

{{-- go back button --}}
<div class="container d-flex bootstrap-grid mt-2">
    <a href="{{ url()->previous() }}" class="btn btn-primary">Go Back</a>
</div>

{{-- shelter information --}}

<div class="container d-flex bootstrap-grid mb-2 mt-2 text-center mx-auto">

<<<<<<< HEAD
    <div class="card mb-3 col-lg-12 col-md-12 col-sm-12 mx-auto">


        <img src="{{ route('getImage', ['imageName' => $result['Shelter Name']]) }}"class="card-img-top informationImages" alt="Shelter Image">

        <div class="card-body">
            <h5 class="card-title">{{ $result['Shelter Name'] }}</h5>
            <p class="card-text">{{ $result['Location'] }}</p>
            <a class="card-text" href="tel:{{ $result['Contact Info'] }}"> {{ $result['Contact Info'] }}</a>
            <h5 class="card-text">Avalible Beds: {{ $result['Beds'] }}</h5>
            <p class="card-text"><small class="text-muted">Last Updated: {{ $result['Timestamp'] }}</small></p>
            @foreach(array_slice($result, 6) as $key => $info)
            @if($info != 'No')
            <p class="card-text">{{ $key }}: {{ $info }}</p>
            @endif
            @endforeach
=======
    <div class="card mb-3 col-lg-12 col-md-12 col-sm-12 mx-auto card-width">


        <img src="{{ route('getImage', ['imageName' => $result['Shelter Name']]) }}" class="card-img-top results" alt="Shelter Image">

        <div class="card-body">
            <h5 class="card-title">{{ $result['Shelter Name'] }}</h5>
            <p class="card-text" style="margin-bottom: -0.25em;">{{ $result['Location'] }}</p>
            <a class="card-text" href="tel:{{ $result['Contact Info'] }}"> {{ $result['Contact Info'] }}</a>
            <h5 class="card-text">Available Beds: {{ $result['Beds'] }}</h5>
            <p class="card-text"><small class="text-muted">Last Updated: {{ $result['Timestamp'] }}</small></p>
            <hr>
            @foreach(array_slice($result, 6) as $key => $info)
                @if($info != 'No' && $key != "Row Number")
                <p class="card-text text-start">{{ $key }}: {{ $info }}</p>
                @endif
            @endforeach
            <hr>
>>>>>>> ace942775e5443771e3fc9d362ee04fd45a4fbb5
            <a class="btn btn-primary" href="{{ route('mapView', ['shelterRow' => $result['Row Number'], 'shelterName' => Str::slug($result['Shelter Name'], '-') ]) }}">Get Directions</a>
        </div>
    </div>
</div>

@endsection