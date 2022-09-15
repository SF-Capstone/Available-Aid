@extends('includes.header')


@section('body')
@include('includes.filterModal')
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
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
.btn {
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
 /* Make the image fully responsive */
 .carousel-inner img {
    width: 100%;
    height: 100%;
  }

</style>

<div class="container d-flex bootstrap-grid mb-2 mt-4 text-center mx-auto">
    <div class="row row1 mx-auto">
        <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
         
            <h1>Welcome to Avalible Aid</h1>
            <h2>
                Find a place to stay!
            </h2>
            <!--<div class='gap'></div>-->
            <button type="button" class="btn search" data-bs-toggle="modal" data-bs-target="#ModalCenter"><div class="BlackSpaceDivClass"> Search</div></button>
        </div>
      </div>
</div>

<div id="demo" class="carousel slide" data-ride="carousel">
<div class='gap'></div>
<div class="BlackSpaceDivClass"> </div>
  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>
  
  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/home1.jpg" alt="home1" width="1100" height="338">
      <div class="carousel-caption">
        <h3>Blanchet House</h3>
        <p>Welcome to Blanchet House!</p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="images/home2.jpg" alt="home2" width="1100" height="338">
      <div class="carousel-caption">
        <h3>Clark Center</h3>
        <p>Welcome to Clark Center!</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/home3.jpg" alt="home3" width="1100" height="338">
      <div class="carousel-caption">
        <h3>Portland Rescur Mission</h3>
        <p>Welcome to Portland Rescur Mission!</p>
      </div>
    </div>
  </div>
  
  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>
    



@endsection