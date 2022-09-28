@extends('includes.header')



@section('body')

<div class="container d-flex bootstrap-grid mb-2 mt-4 text-center mx-auto">
    <div class="row row1 mx-auto">
        <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
            <h1>Welcome to Available Aid</h1>

            @foreach ($lastFormInput as $current)
                <div class="card mb-3 mx-auto" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="..." alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{$current['shelter']}}</h5>
                                <p class="card-text">{{$current['beds']}}</p>
                                <p class="card-text">{{$current['address']}}</p>
                                <p class="card-text"><small class="text-muted">{{$current['phone']}}</small></p>
                                <p class="card-text"><small class="text-muted">Last Updated: {{$current['timestamp']}}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
</div>



@endsection