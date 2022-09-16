@extends('includes.header')


@section('body')
@include('includes.filterModal')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


<style>
.gap{
  width:200px;
  background:none;
  height:100px;
  display:inline-block;}

h2{
  font-family: 'Open Sans';
  font-style: normal;
  font-weight: 400;
  font-size: 24px;
  line-height: 33px;
  display: flex;
  align-items: center;
  text-align: center;
  letter-spacing: -0.333333px;
  color: #F0EBE3;
}
.btn1 {
  position: absolute;
  border: none;
  background-color: inherit;
  padding: 14px 28px;
  font-weight: 400;
  font-size: 16px;
  cursor: pointer;
  display: inline-block;
}

.search{
  background-color: #7D9D9C;
  color:  #F0EBE3
}

.search:hover {
  color: #7D9D9C;
}

.card{
  position: relative;
  border: none;
  left:10%;
  padding: 14px 28px;
  width: 402px;
  height: 424px;
  background: #F0EBE3;
  box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.25);
  cursor: pointer;
  display: inline-block;
}



</style>

<div class="container d-flex bootstrap-grid mb-2 mt-4 text-center mx-auto">
    <div class="row row1 mx-auto">
        <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
         
            <h1>Welcome to Avalible Aid</h1>
            <h2>
                Find a place to stay!
            </h2>
            <button type="button" class="btn1 search" data-bs-toggle="modal" data-bs-target="#ModalCenter"> Search</button> 

        </div>
      </div>
</div>
<div>
@include('includes.carousel')
<div class='card'>
  <h5>Map Card</h5>
    <p>Find the shelter by location?</p>
    <i class="material-icons" style="font-size:200px">map</i>
    <div class='gap'></div>
  <button type="button" class="btn1 search" > View Map</button>
</div>
<div class='gap'></div>
<div class='card'>
  <h5>Information</h5>
    <p>Need help?</p>
    <i class="material-icons" style="font-size:200px">local_phone</i>
    <div class='gap'></div>
    <button type="button" class="btn1 search" > About Us</button>
</div>





@endsection