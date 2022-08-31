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
    </div>
</div>        
<button type="button" class="btn btn-primary container d-flex justify-content-center col-2" data-bs-toggle="modal" data-bs-target="#ModalCenter">Search</button>

{{-- LOOP THROUGH ALL FITLERS --}}
<form action="" method="" enctype="">
@csrf
    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labeledby="ModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalCenterTitle">Search</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach($result->values as $filter)
                        {{-- RADIO BUTTON --}}
                        @if($filter[1] == "Radio Button")
                            <div class="mb-3">
                                <p>{{$filter[0]}}</p>
                                @foreach(array_slice($filter, 3) as $option)
                                    <a>
                                        @if($filter[2] == "Yes")
                                            <input onclick="" type="radio" class="btn-check typeRadio" name="{{$filter[0]}}Filter" id="{{$option}}" autocomplete="off" required>
                                        @else
                                            <input onclick="" type="radio" class="btn-check typeRadio" name="{{$filter[0]}}Filter" id="{{$option}}" autocomplete="off">
                                        @endif
                                        <label class="btn btn-outline-primary me-2" for="{{$option}}">{{$option}}</label>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    
                        {{-- CHECK BOX --}}
                        @if($filter[1] == "Check Box")
                            <div class="d-flex flex-row">
                                <div class="form-check form-switch form-check-reverse mb-3">
                                    @if($filter[2] == "Yes")
                                        <input type="checkbox" class="form-check-input" name="{{$filter[0]}}Filter" id="{{$filter[0]}}" autocomplete="off" required>
                                    @else
                                        <input type="checkbox" class="form-check-input" name="{{$filter[0]}}Filter" id="{{$filter[0]}}" autocomplete="off">
                                    @endif
                                    <label class="form-check-label" for="{{$filter[0]}}">{{$filter[0]}}</label>
                                </div>
                            </div>
                        @endif

                        {{-- SLIDER --}}
                        @if($filter[1] == "Slider")
                            <div class="form-group mb-3">
                                <label for="{{$filter[0]}}">{{$filter[0]}}</label>
                                <input type="range" class="form-control-range align-middle ms-4" name="{{$filter[0]}}Filter" id="{{$filter[0]}}" min="{{$filter[3]}}" max="{{$filter[4]}}" step="1" autocomplete="off">
                            </div>
                        @endif

                        {{-- MUTLI SELECT --}}
                        @if($filter[1] == "Multiple Select")
                            <div class="form-group mb-3">
                                <p>{{$filter[0]}}</p>
                                @foreach(array_slice($filter, 3) as $option)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="{{$option}}Filter" id="{{$option}}" autocomplete="off">
                                        <label class="form-check-label" for="{{$option}}">{{$option}}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- DROPDOWN --}}
                        @if($filter[1] == "Drop Down")
                            <div class="form-group mb-3">
                                <label for="{{$filter[0]}}">{{$filter[0]}}</label>
                                <div class="d-flex col-6">
                                    @if($filter[2] == "Yes")
                                        <select class="form-select mt-1" name="{{$filter[0]}}Filter" id="{{$filter[0]}}" autocomplete="off" required>
                                            @foreach(array_slice($filter, 3) as $option)
                                                <option value="{{$option}}">{{$option}}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select class="form-select mt-1" name="{{$filter[0]}}Filter" id="{{$filter[0]}}" autocomplete="off">
                                            @foreach(array_slice($filter, 3) as $option)
                                                <option value="{{$option}}">{{$option}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                        @endif

                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Continue</button>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- END LOOP --}}


@endsection