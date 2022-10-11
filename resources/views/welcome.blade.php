@extends('includes.header')


@section('body')
@include('includes.filterModal')
<meta name='viewport' content='width=device-width, initial-scale=1'>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>


<style>
.gap{
  width:50px;
  background:none;
  height:50px;
  display:inline-block;}

h1{
  font-family: 'Open Sans';
  font-style: normal;
  font-weight: 400;
  font-size: 30px;
  line-height: 20px;
  text-shadow: -0.5px 0.5px 0 #7D9D9C, 0.5px 0.5px 0 #7D9D9C, 0.5px -0.5px 0 #7D9D9C,-0.5px -0.5px 0 #7D9D9C;
  display: flex;
  align-items: center;
  text-align: center;
  letter-spacing: -0.333333px;
  color: #576F72;
}

h2{
  font-family: 'Open Sans';
  font-style: normal;
  font-weight: 400;
  font-size: 10px;
  line-height: 20px;
  text-shadow: -0.5px 0.5px 0 #000, 0.5px 0.5px 0 #000, 0.5px -0.5px 0 #000,-0.5px -0.5px 0 #000;
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

.top-image {
  background: url("images/top-main.jpg") no-repeat center; 
  background-size: cover;
  height: 300px;
  position: relative;
}

.top-text {
  text-align: center;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
}


</style>

<div class="top-image">
  <div class="top-text">
    <h1 style="font-size:30px,">Available Aid</h1>
        <h2>Avaiable Aid serves anyone who try to find safe shelter in Portland. </h2>
        <h2>We offer different types of beds.</h2>
        <button type="button" class="btn1 search" data-bs-toggle="modal" data-bs-target="#ModalCenter"> Search</button> 
  </div>
</div>


@include('includes.carousel')

<h1 style="font-size:20px,"> Need Help?</h1>
<button style='font-size:24px'>Contact us <i class='fas fa-phone'></i></button>



@endsection
<div class='gap'></div>
