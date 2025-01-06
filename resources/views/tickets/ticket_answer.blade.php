
    <input type="hidden" id="user_id" value="{{$user->id}}">
    <input type="hidden" id="ticket_id" value="{{$ticket->id}}">
    @if(isset($ticket_answer))
        <div class="row border border-success m-3 p-3 mb-3">
            <div class="col-md-12">

                <h4 class="text-success">{{__('Answer')}} :--@ {{$user->name}} </h4>

                <span style="font-size: 16px;">{{ isset($ticket_answer) ?  $ticket_answer->answer : '' }}</span>
                <!--end::Datepicker-->
            </div>
        </div>
    @else
        <div class="row border border-success m-3 p-3 mb-3">
            <div class="col-md-12">

                <h4 class="text-success">{{__('Answer')}} : </h4>

                <textarea name="answer" id="ticket_answer" class="form-control form-control-solid mb-3 mb-lg-0"
                          placeholder="{{__('Details')}}"></textarea>
                <!--end::Datepicker-->
            </div>
            <div class="text-left pt-5">
                <a href="#" class="btn btn-primary submitAnswer" id="submitAnswer" >
                    <span style="font-size: 16px;" class="indicator-label">{{__('Submit')}}</span>
                    <span style="font-size: 16px;" class="wait-progress d-none">{{__('Please wait...')}}
                          <span style="font-size: 16px;"
                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </a>


            </div>
        </div>

    @endif




