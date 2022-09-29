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

.top-image {
  background: url("images/top-main.jpg") no-repeat center; 
  background-size: cover;
  height: 800px;
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
    <h1 style="font-size:50px">welcome to avalible aid</h1>
        <h3>find a place to stay</h3>
        <button type="button" class="btn1 search" data-bs-toggle="modal" data-bs-target="#ModalCenter"> Search</button> 
  </div>
</div>




@include('includes.carousel')






@endsection