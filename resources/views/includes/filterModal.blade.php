

{{-- LOOP THROUGH ALL FITLERS --}}
<form action="{{ route('results') }}" method="GET" enctype="multipart/form-data">
@csrf
    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labeledby="ModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
<<<<<<< HEAD
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalCenterTitle">Search</h5>
=======
            <div class="modal-content filterModal">
                <div class="modal-header">
                    <h2 class="modal-title" id="ModalCenterTitle">Search</h2>
>>>>>>> ace942775e5443771e3fc9d362ee04fd45a4fbb5
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach($result->values as $filter)
                        {{-- RADIO BUTTON --}}
                        @if($filter[1] == "Radio Button")
                            <div class="mb-3">
<<<<<<< HEAD
                                <p>{{$filter[0]}}</p>
=======
                                <p class="fw-bold">{{$filter[0]}}</p>
>>>>>>> ace942775e5443771e3fc9d362ee04fd45a4fbb5
                                @foreach(array_slice($filter, 3) as $option)
                                    <a>
                                        @if($filter[2] == "Yes")
                                            <input onclick="" type="radio" class="btn-check typeRadio" name="{{$filter[0]}}" id="{{$option}}" value="{{$option}}" autocomplete="off" required>
                                        @else
                                            <input onclick="" type="radio" class="btn-check typeRadio" name="{{$filter[0]}}" id="{{$option}}" value="{{$option}}" autocomplete="off">
                                        @endif
<<<<<<< HEAD
                                        <label class="btn btn-outline-primary me-2" for="{{$option}}">{{$option}}</label>
=======
                                        <label class="btn btn-secondary me-2" for="{{$option}}">{{$option}}</label>
>>>>>>> ace942775e5443771e3fc9d362ee04fd45a4fbb5
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    
                        {{-- CHECK BOX --}}
                        @if($filter[1] == "Check Box")
                            <div class="d-flex flex-row">
                                <div class="form-check form-switch form-check-reverse mb-3">
                                    @if($filter[2] == "Yes")
                                        <input type="checkbox" class="form-check-input" name="{{$filter[0]}}" id="{{$filter[0]}}" autocomplete="off" required>
                                    @else
                                        <input type="checkbox" class="form-check-input" name="{{$filter[0]}}" id="{{$filter[0]}}" autocomplete="off">
                                    @endif
<<<<<<< HEAD
                                    <label class="form-check-label" for="{{$filter[0]}}">{{$filter[0]}}</label>
=======
                                    <label class="form-check-label fw-bold" for="{{$filter[0]}}">{{$filter[0]}}</label>
>>>>>>> ace942775e5443771e3fc9d362ee04fd45a4fbb5
                                </div>
                            </div>
                        @endif

                        {{-- SLIDER --}}
                        @if($filter[1] == "Slider")
                            <div class="form-group mb-3">
<<<<<<< HEAD
                                <label for="{{$filter[0]}}">{{$filter[0]}}</label>
=======
                                <label class="fw-bold" for="{{$filter[0]}}">{{$filter[0]}}</label>
>>>>>>> ace942775e5443771e3fc9d362ee04fd45a4fbb5
                                <input type="range" class="form-control-range align-middle ms-4" name="{{$filter[0]}}" id="{{$filter[0]}}" min="{{$filter[3]}}" max="{{$filter[4]}}" step="1" autocomplete="off">
                            </div>
                        @endif

                        {{-- MUTLI SELECT --}}
                        @if($filter[1] == "Multiple Select")
                            <div class="form-group mb-3">
<<<<<<< HEAD
                                <p>{{$filter[0]}}</p>
=======
                                <p class="fw-bold">{{$filter[0]}}</p>
>>>>>>> ace942775e5443771e3fc9d362ee04fd45a4fbb5
                                @foreach(array_slice($filter, 3) as $option)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="{{$option}}" id="{{$option}}" autocomplete="off">
                                        <label class="form-check-label" for="{{$option}}">{{$option}}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- DROPDOWN --}}
                        @if($filter[1] == "Drop Down")
                            <div class="form-group mb-3">
<<<<<<< HEAD
                                <label for="{{$filter[0]}}">{{$filter[0]}}</label>
=======
                                <label class="fw-bold" for="{{$filter[0]}}">{{$filter[0]}}</label>
>>>>>>> ace942775e5443771e3fc9d362ee04fd45a4fbb5
                                <div class="d-flex col-6">
                                    @if($filter[2] == "Yes")
                                        <select class="form-select mt-1" name="{{$filter[0]}}" id="{{$filter[0]}}" autocomplete="off" required>
                                            @foreach(array_slice($filter, 3) as $option)
                                                <option value="{{$option}}">{{$option}}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select class="form-select mt-1" name="{{$filter[0]}}" id="{{$filter[0]}}" autocomplete="off">
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