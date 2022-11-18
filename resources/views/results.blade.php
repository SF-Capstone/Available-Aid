@extends('includes.header')
@section('body')
<div class="container d-flex bootstrap-grid mb-2 mt-4 text-center mx-auto">
        <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
            <h1>Shelter Results</h1>
            <hr>
            
            @if (count($lastFormInput) == 0)
                <h2 class="noResults">Sorry, no results found with your current filters.</h2>
            @else
                @foreach ($lastFormInput as $current)
                    <div class="card mb-3 mx-auto justify-content-center card-width">
                        <div class="row g-0">
                            <div>
                                <img src="{{ route('getImage', ['imageName' => $current['shelter']]) }}" class="card-img-top results" alt="Shelter Image">
                            </div>
                            <div>
                                <div class="card-body">
                                    <p class="card-title fw-bold fs-3">{{$current['shelter']}}</p>
                                    <p class="card-text fw-bold">{{$current['beds']}} <br>
                                    <small class="text-muted fw-normal">Last Updated: {{$current['timestamp']}}</small></p>
                                    
                                    <a class="btn btn-primary" href="{{ route('info', ['shelterRow' => $current['row'], 'shelterName' => Str::slug($current['shelter'], '-') ]) }}">Get More Information</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>



@endsection