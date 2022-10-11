@extends('includes.header')


@section('body')
@include('includes.filterModal')
<meta name='viewport' content='width=device-width, initial-scale=1'>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>


<style>

.search{
  background-color: #7D9D9C;
  color:  #F0EBE3
}

.search:hover {
  color: #7D9D9C;
}

.top-image {
  background: url("images/top-main.jpg") no-repeat center; 
  background-size: cover;
  background-position: top;
  height: 250px;
  position: relative;
}


</style>

<div class="top-image">
  <img>
</div>
<div class="text-light card shadow-sm my-3 mx-5 p-4 border-0" style="background-color: #F0EBE3">
    <h1 class="text-center">Available Aid</h1>
    <p class="fs-5" style="color: #7D9D9C">Avaiable Aid serves anyone who try to find safe shelter in Portland. <br> We offer different types of beds.</p>
    <button type="button" class="col-5 btn btn-lg search mx-auto" data-bs-toggle="modal" data-bs-target="#ModalCenter"> Search</button> 
</div>
<br>


{{--@include('includes.carousel')--}}
{{--
<h1 class="text-center"> Need Help?</h1>
<button class="btn">Contact us <i class='fas fa-phone'></i></button>
--}}


@endsection