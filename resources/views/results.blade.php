@extends('includes.header')



@section('body')


{{-- $shelterResultInfo->values as $shelter, [0] = name, [1] = contact info, [2] = location, [3] = row of last form entry --}} 

<div class="container d-flex bootstrap-grid mb-2 mt-4 text-center mx-auto">
    <div class="row row1 mx-auto">
        <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
            <h1>Welcome to Avalible Aid</h1>
            <p>
                Results!
            </p>
            {{dd($lastFormInput)}}
            <br>
            @foreach($shelterResultInfo->values as $shelter)
                <p>{{$shelter[0]}}</p>
            @endforeach
        </div>
    </div>
</div>



@endsection