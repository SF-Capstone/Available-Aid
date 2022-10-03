@extends('includes.header')


@section('body')
@include('includes.filterModal')

<div class="container d-flex bootstrap-grid mb-2 mt-4 text-center mx-auto">
    <div class="row row1 mx-auto">
        <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
            <h1>Welcome to Availible Aid</h1>
            <p>
                beds!
            </p>
        </div>
    </div>
</div>        
<button type="button" class="btn btn-primary container d-flex justify-content-center col-2" data-bs-toggle="modal" data-bs-target="#ModalCenter">Search</button>


@endsection