@extends('includes.header')
@section('body')
<div class="container d-flex bootstrap-grid mb-2 mt-4 text-center mx-auto">
    <div class="row row1 mx-auto">
        <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
<<<<<<< HEAD
            <h1>Welcome to Available Aid</h1>

            

            @foreach ($lastFormInput as $current)
                <div class="card mb-3 mx-auto" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                        <img src="{{ route('getImage', ['imageName' => $current['shelter']]) }}"class="card-img-top" alt="Shelter Image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{$current['shelter']}}</h5>
                                <p class="card-text">{{$current['beds']}}</p>
                                <p class="card-text"><small class="text-muted">{{$current['phone']}}</small></p>
                                <p class="card-text"><small class="text-muted">Last Updated: {{$current['timestamp']}}</small></p>
=======
            <h1>Shelter Results</h1>
            <hr>
            

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
                                
>>>>>>> ace942775e5443771e3fc9d362ee04fd45a4fbb5
                                <a class="btn btn-primary" href="{{ route('info', ['shelterRow' => $current['row'], 'shelterName' => Str::slug($current['shelter'], '-') ]) }}">Get More Information</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>



@endsection