@extends('includes.header')


@section('body')

<div class="container d-flex bootstrap-grid mb-2 mt-4 text-center mx-auto">
    <div class="row row1 mx-auto">
        <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
            <h1>Welcome to Avalible Aid</h1>
            <p>
                beds!
            </p>
        </div>

        {{-- LOOP THROUGH ALL FITLERS --}}
        <form>
        @csrf
            @foreach($result->values as $filter)
                {{-- RADIO BUTTON --}}
                @if($filter[1] == "Radio Button")
                    <div>
                        <p>{{$filter[0]}}</p>
                        @foreach(array_slice($filter, 2) as $option)
                            <a>
                                <input onclick="" type="radio" class="btn-check typeRadio" name="{{$filter[0]}}Filter" id="{{$option}}" autocomplete="off">
                                <label class="btn btn-outline-primary" for="{{$option}}">{{$option}}</label>
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- CHECK BOX --}}
                @if($filter[1] == "Check Box")
                    <div class="form-check form-switch form-check-reverse">
                        <input type="checkbox" class="form-check-input" name="{{$filter[0]}}Filter" id="{{$filter[0]}}" autocomplete="off">
                        <label class="form-check-label" for="{{$filter[0]}}">{{$filter[0]}}</label>
                    </div>
                @endif

                {{-- SLIDER --}}
                @if($filter[1] == "Slider")
                    <div class="form-group">
                        <label for="{{$filter[0]}}">{{$filter[0]}}</label>
                        <input type="range" class="form-control-range" name="{{$filter[0]}}Filter" id="{{$filter[0]}}" min="{{$filter[2]}}" max="{{$filter[3]}}" step="1" autocomplete="off">
                    </div>
                @endif

                {{-- MUTLI SELECT --}}
                @if($filter[1] == "Multiple Select")
                    <div class="form-group">
                        <p>{{$filter[0]}}</p>
                        @foreach(array_slice($filter, 2) as $option)
                            <div class="form-check form-switch form-check-reverse">
                                <input type="checkbox" class="form-check-input" name="{{$option}}Filter" id="{{$option}}" autocomplete="off">
                                <label class="form-check-label" for="{{$option}}">{{$option}}</label>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- DROPDOWN --}}
                @if($filter[1] == "Drop Down")
                    <div class="form-group">
                        <label for="{{$filter[0]}}">{{$filter[0]}}</label>
                        <select class="form-control" name="{{$filter[0]}}Filter" id="{{$filter[0]}}" autocomplete="off">
                            @foreach(array_slice($filter, 2) as $option)
                                <option value="{{$option}}">{{$option}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

            @endforeach
        </form>
        {{-- END LOOP --}}
    </div>
</div>


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