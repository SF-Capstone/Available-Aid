@extends('includes.header')


@section('body')
@include('includes.filterModal')
<style>

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

</style>

<div class="container d-flex bootstrap-grid mb-2 mt-4 text-center mx-auto">
    <div class="row row1 mx-auto">
        <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
            <h1>Welcome to Avalible Aid</h1>
            <h2>
                Find a place to stay!
            </h2>
            <button type="button" class="btn search" data-bs-toggle="modal" data-bs-target="#ModalCenter">Search</button>
        </div>
    </div>
</div>        



@endsection