@extends('includes.header')


@section('body')
@include('includes.filterModal')
<meta name='viewport' content='width=device-width, initial-scale=1'>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

<div class="top-image"></div>
<div class="container">
<div class="card my-3 mx-auto p-4 card-width">
    <h1 class="text-center">Available Aid</h1>
    <p class="fs-5">Avaiable Aid serves anyone who try to find safe shelter in Portland. We offer different types of beds.</p>
    <button type="button" class="col-5 btn btn-lg mx-auto btn-primary" data-bs-toggle="modal" data-bs-target="#ModalCenter"> Search</button> 
</div>
</div>
<br>


{{--@include('includes.carousel')--}}
{{--
<h1 class="text-center"> Need Help?</h1>
<button class="btn">Contact us <i class='fas fa-phone'></i></button>
--}}


@endsection