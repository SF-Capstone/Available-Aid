@extends('includes.header')


@section('body')
@include('includes.filterModal')

<div class="container d-flex bootstrap-grid mb-2 mt-4 text-center mx-auto">
    <div class="row row1 mx-auto">
        <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
            <h1>Welcome to Avalible Aid</h1>
            <p>
                beds!
            </p>
        </div>
    </div>
</div>        
<button type="button" class="btn btn-primary container d-flex justify-content-center col-2" data-bs-toggle="modal" data-bs-target="#ModalCenter">Search</button>

<<<<<<< HEAD

@endsection
=======
<script>
    $(document).ready(() => {
        getLocationData();
    });
    //using the geolocation api to get the user's location
    function getLocationData() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                console.log(position.coords.latitude, position.coords.longitude);
            });
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    }
</script>

@endsection
>>>>>>> 593845a (Rebasing off of develop)
