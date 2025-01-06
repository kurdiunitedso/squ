<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_ticket_header">
        <!--begin::Modal title-->
        <h2 class="fw-bold">{{__('Add Ticket')}}</h2>
        <!--end::Modal title-->
        <!--begin::Close-->
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
            <span style="font-size: 16px;" class="svg-icon svg-icon-1">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                            transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                      <rect x="7.41422" y="6" width="16" height="2" rx="1"
                            transform="rotate(45 7.41422 6)" fill="currentColor"/>
                  </svg>
              </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Close-->
    </div>
    <!--end::Modal header-->
    <!--begin::Modal body-->
    <div class="modal-body scroll-y mx-5 my-7">
        <!--begin::Form-->

        <!--begin::Scroll-->
        <form id="kt_modal_add_ticket_form" class="form"
              data-editMode="{{ isset($ticket) ? 'enabled' : 'disabled' }}"
              action="{{ isset($ticket) ? route('tickets.update', ['ticket' => $ticket->id]) : route('tickets.store') }}">
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_ticket_scroll"
                 data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                 data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_ticket_header"
                 data-kt-scroll-wrappers="#kt_modal_add_ticket_scroll" data-kt-scroll-offset="300px">
                <!--begin::Input group-->
                <div class="row border border-success m-3 p-3 mb-3">
                    <input type="hidden" name="updateAnswer" value="1">
                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Date')}}: </h4>


                        <span style="font-size: 16px;">{{ isset($ticket)
                                            ? ($ticket->ticket_date
                                                ? \Carbon\Carbon::parse($ticket->ticket_date)->format('Y-m-d')
                                                : old('ticket_date'))
                                            : old('ticket_date') }}</span>
                        <!--end::Datepicker-->
                    </div>

                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Time')}}: </h4>


                        <span style="font-size: 16px;">{{ isset($ticket)
                                            ? ($ticket->ticket_date
                                                ? \Carbon\Carbon::parse($ticket->ticket_date)->format('H:i')
                                                : old('ticket_date'))
                                            : old('ticket_date') }}</span>
                        <!--end::Datepicker-->
                    </div>
                    <div class="col-md-4 p-3 mb-3">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2">{{__('Status')}}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="status" id="status" data-placeholder="Select an option">
                                <option></option>
                                @foreach ($status as $t)
                                    <option value="{{ $t->id }}"
                                    @if (isset($ticket))
                                        @selected($ticket->status ==$t->id)
                                        @endif>
                                        {{ $t->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>

                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Employee')}}: </h4>


                        <span style="font-size: 16px;">{{$ticket->employees->name }}</span>
                        <!--end::Datepicker-->
                    </div>

                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Name')}} : </h4>


                        <span style="font-size: 16px;">{{ isset($ticket) ? $ticket->request_name : '' }}</span>
                        <!--end::Datepicker-->
                    </div>


                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Ticket Number')}} : </h4>


                        <span style="font-size: 16px;">{{ isset($ticket) ? $ticket->ticket_number : '' }}</span>
                        <!--end::Datepicker-->
                    </div>
                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Ticket Type')}} : </h4>


                        <span style="font-size: 16px;">{{ isset($ticket) ? $ticket->ticket_types->name : '' }}</span>
                        <!--end::Datepicker-->
                    </div>

                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Purpose')}} : </h4>


                        <span style="font-size: 16px;">{{ $ticket->purposes->name }}</span>
                        <!--end::Datepicker-->
                    </div>


                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Telephone')}} : </h4>


                        <span style="font-size: 16px;">{{ isset($ticket) ? $ticket->telephone : '' }}</span>
                        <!--end::Datepicker-->
                    </div>

                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Email')}} : </h4>


                        <span style="font-size: 16px;">{{ isset($ticket) ? $ticket->email : '' }}</span>
                        <!--end::Datepicker-->
                    </div>

                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('City')}} : </h4>


                        <span style="font-size: 16px;">{{ isset($ticket) ?  $ticket->cities->name : '' }}</span>
                        <!--end::Datepicker-->
                    </div>
                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Source')}} : </h4>


                        <span style="font-size: 16px;">{{ isset($ticket) ? $ticket->source : '' }}</span>
                        <!--end::Datepicker-->
                    </div>
                </div>
                <div class="separator separator-dashed my-6"></div>
                <div class="row border border-success m-3 p-3 mb-3">

                    <div class="col-md-12">

                        <h4 class="text-success">{{__('Details')}} : </h4>


                        <span style="font-size: 16px;">{{ isset($ticket) ?  $ticket->details : '' }}</span>
                        <!--end::Datepicker-->
                    </div>
                </div>
                <div class="separator separator-dashed my-6"></div>
                @if(in_array($ticket->purpose,[197,219]))
                    <div class="row border refund border-success m-3 p-3 mb-3">
                        <div class="col-md-3  mb-3">
                            <div class="fv-row mb-4">
                                <!--begin::Label-->
                                <label class=" fw-semibold fs-6 mb-2">{{__('Target')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                        name="target" id="target" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach ($targets as $t)
                                        <option value="{{ $t->id }}"
                                        @if (isset($ticket))
                                            @selected($ticket->target ==$t->id)
                                            @endif>
                                            {{ $t->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="col-md-3  mb-3">
                            <div class="fv-row mb-4">
                                <!--begin::Label-->
                                <label class=" fw-semibold fs-6 mb-2">{{__('Destination')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                        name="destination" id="destination" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach ($destinations as $t)
                                        <option value="{{ $t->id }}"
                                        @if (isset($ticket))
                                            @selected($ticket->destination ==$t->id)
                                            @endif>
                                            {{ $t->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="col-md-3  mb-3 ">
                            <label class=" fw-semibold fs-6 mb-2">{{__('Refund')}}</label>
                            <div class="align-items-center d-flex flex-row me-4">

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_refund"
                                           name="is_refund"
                                    @isset($ticket)
                                        @checked($ticket->refund == 1)
                                        @endisset>
                                    <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                                           for="refund">  {{ __('Refund') }}?</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3  mb-3">
                            <div class="fv-row mb-4">
                                <!--begin::Label-->
                                <label class=" fw-semibold fs-6 mb-2">{{__('Refund Type')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                        name="refund_type" id="refund_type" data-placeholder="Select an option">
                                    <option></option>
                                    @foreach ($refund_type as $t)
                                        <option value="{{ $t->id }}"
                                        @if (isset($ticket))
                                            @selected($ticket->refund_type ==$t->id)
                                            @endif>
                                            {{ $t->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="col-md-3  mb-3 ">
                            <div class="fv-row mb-4">
                                <!--begin::Label-->
                                <label class=" fw-semibold fs-6 mb-2">{{__('Refund Amount')}} </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="refund_amount"
                                       class="form-control form-control-solid mb-3 mb-lg-0"
                                       placeholder="{{__('Refund Amount')}}"
                                       value="{{ isset($ticket) ? $ticket->refund_amount : '' }}"/>
                                <!--end::Input-->
                            </div>
                        </div>
                    </div>
                @endif

                <div class="tickerAnswers">
                    @foreach($tickerAnswers as $t)
                        <div class="row border border-success m-3 p-3 mb-3  ">
                            <div class="col-md-12">

                                <h4 class="text-success">{{__('Answer')}} :{{__('By')}} {{$t->user?$t->user->name:''}} @ {{\Carbon\Carbon::parse($t->created_at)->diffForHumans()}} </h4>

                                <span style="font-size: 16px;">{{ isset($t) ?  $t->answer : '' }}</span>
                                <!--end::Datepicker-->
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="separator separator-dashed my-6"></div>

                <div class="row border border-success m-3 p-3 mb-3">
                    <div id="ticketAnswer">
                        @include('tickets.ticket_answer')
                    </div>

                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
            </div>


            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-ticket-modal-action="cancel"
                        data-bs-dismiss="modal">{{__('Discard')}}
                </button>
                <button type="submit" class="btn btn-primary" data-kt-ticket-modal-action="submit">
                    <span style="font-size: 16px;" class="indicator-label">{{__('Submit')}}</span>
                    <span style="font-size: 16px;" class="indicator-progress">{{__('Please wait...')}}
                          <span style="font-size: 16px;"
                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Actions-->
        </form>

        <!--end::Form-->
    </div>
    <!--end::Modal body-->
</div>
<!--end::Modal content-->
<script>
    $('#submitAnswer').click(function () {
        // Get the value from the input field
        var answer = $('#ticket_answer').val();
        var user_id = $('#user_id').val();
        var ticket_id = $('#ticket_id').val();
        $(this).find('.indicator-label').addClass('d-none');
        $(this).find('.wait-progress').removeClass('d-none');
        // Send the Ajax POST request
        $.ajax({
            url: '/tickets/' + ticket_id + '/storeAnswer/', // Replace with your server URL
            type: 'GET',
            data: {answer: answer, user_id: user_id, ticket_id: ticket_id},
            success: function (response) {
                // Append the response to the div

                $('.tickerAnswers ').append(response);
            },
            error: function (xhr, status, error) {
                // Handle any errors
                console.error('Error:', error);
            },
            complete: function () {
                $('#submitAnswer').find('.indicator-label').removeClass('d-none');
                $('#submitAnswer').find('.wait-progress ').addClass('d-none');
            }

        });
    });
</script>
