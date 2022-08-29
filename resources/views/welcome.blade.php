@extends('includes.header')


@section('body')

<div class="container d-flex bootstrap-grid text-light mb-2 mt-4 text-center  mx-auto">
    <div class="row row1 mx-auto">
        <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
            <h1>Welcome to Avalible Aid</h1>
            <p>
                beds!
            </p>
            <button onclick="loadFilters()">Get Started</button>
            <p id="filters">
            </p>
        </div>
    </div>
</div>


<script>
    function loadFilters() {
        axios.get("{{ route('getFilterInfo') }}")
            .then(function (response) {
                console.log(response);
                let filters = document.getElementById("filters");
                filters.innerHTML = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
    }
</script>
@endsection