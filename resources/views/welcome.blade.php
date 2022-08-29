@extends('includes.header')


@section('body')

<div class="container d-flex bootstrap-grid mb-2 mt-4 text-center mx-auto">
    <div class="row row1 mx-auto">
        <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
            <h1>Welcome to Avalible Aid</h1>
            <p>
                beds!
            </p>
            <button onclick="loadFilters()">Get Started</button>
            <div id="filters">
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        loadFilters();
    });

    function loadFilters() {
        axios.get("{{ route('getFilterInfo') }}")
            .then(function (response) {
                //console.log(response.data);
                makeFilters(response.data);
                //let filters = document.getElementById("filters");
                //filters.innerHTML = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    function makeFilters(data) {
        for(let i = 0; i < data.values.length; i++) {
            let type = data.values[i][1];

            switch(type){
                case "Radio Button":
                    makeRadio(data.values[i]);
                    break;
                case "Check Box":
                    makeCheck(data.values[i]);
                    break;
                case "Drop Down":
                    makeDropDown(data.values[i]);
                    break;
                case "Slider":
                    makeSlider(data.values[i]);
                    break;
                case "Multiple Select":
                    makeMultipleSelect(data.values[i]);
                    break;
            }
        }
    }

    function makeRadio(data) {
        let filter = $("<div></div>");
        let filterName = $("<p></p>").text(data[0]);
        filter.append(filterName);
        
        let li = $("<li></li>");
        filter.append(li);
        
        let a = $("<a></a>");
        a.addClass("text-light");
        filter.append(a);
        
        
        let input = $("<input>");
        input.type = "radio";
        input.addClass("btn-check typeRadio");
        // needs all of the input options
        for(let i = 2; i < data.length; i++) {
            let label = $("<label></label>").text(data[i]);
            input.append(label);
        }
        a.append(input);
        
        let doc = $("#filters");
        doc.append(filter);
    }
    
    function makeCheck(data) {
            
    }
    function makeDropDown(data) {
        
    }
    function makeSlider(data) {
        
    }
    function makeMultipleSelect(data) {
        
    }
    
</script>


<div class="pt-2 container">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="filter" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
        Filter
    </button>

    <ul class="dropdown-menu dropdown-menu-dark p-2 " aria-labelledby="filter">
        <p>Gender</p>
        <li id="Gender">
            <a>
                <input onclick="" type="radio" class="btn-check typeRadio" name="genderFilter" id="male" autocomplete="off">
                <label class="btn btn-outline-primary" for="male">Male</label>
            </a>
            <a>
                <input onclick="" type="radio" class="btn-check typeRadio" name="genderFilter" id="female" autocomplete="off">
                <label class="btn btn-outline-primary" for="female">Female</label>
            </a>
        </li>
            
        <li><hr class="dropdown-divider"></li>
    </ul>
</div>


@endsection