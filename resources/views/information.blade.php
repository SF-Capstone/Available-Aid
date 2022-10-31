@extends('includes.header')
@section('body')



{{-- shelter information --}}

<div class="container d-flex bootstrap-grid mb-2 mt-2 text-center mx-auto">

    <div class="card mb-3 col-lg-12 col-md-12 col-sm-12 mx-auto card-width">


        <img src="{{ route('getImage', ['imageName' => $result['Shelter Name']]) }}" class="card-img-top results" alt="Shelter Image">

        <div class="card-body">
            <h5 class="card-title">{{ $result['Shelter Name'] }}</h5>
            <p class="card-text" style="margin-bottom: -0.25em;">{{ $result['Location'] }}</p>
            <a class="card-text telephone" href="tel:{{ $result['Contact Info'] }}"> {{ $result['Contact Info'] }}</a>
            <h5 class="mt-3 card-text">Available Beds: {{ $result['Beds'] }}</h5>
            <p class="card-text"><small class="text-muted">Last Updated: {{ $result['Timestamp'] }}</small></p>
            <hr>
            @foreach(array_slice($result, 6) as $key => $info)
                @if($info != 'No' && $key != "Row Number" && $info != NULL)
                <p class="card-text text-start"><strong>{{ $key }}:</strong> {{ $info }}</p>
                @endif
            @endforeach
            <hr>
            {{-- go back button --}}
            <a href="{{ url()->previous() }}" class="btn btn-primary">Go Back</a>
            <a class="btn btn-primary ms-2" href="{{ route('mapView', ['shelterRow' => $result['Row Number'], 'shelterName' => Str::slug($result['Shelter Name'], '-') ]) }}">Get Directions</a>
        </div>
    </div>
</div>

@endsection