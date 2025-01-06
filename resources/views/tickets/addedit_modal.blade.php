<div class="modal-content">
    <!--begin::Modal header-->

    <!--end::Modal header-->
    <!--begin::Modal body-->
    <div class="modal-body  ">
        <!--begin::Form-->
        <div class="btn btn-icon btn-sm btn-active-icon-primary " style="left: 0" data-bs-dismiss="modal">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
            <span class="svg-icon svg-icon-1">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                            transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                      <rect x="7.41422" y="6" width="16" height="2" rx="1"
                            transform="rotate(45 7.41422 6)" fill="currentColor"/>
                  </svg>
              </span>
            <!--end::Svg Icon-->
        </div>
        <!--begin::Scroll-->
        <form id="kt_modal_add_ticket_form" class="form"
              data-editMode="{{ isset($ticket) ? 'enabled' : 'disabled' }}"
              action="{{ isset($ticket) ? route('tickets.update', ['ticket' => $ticket->id]) : route('tickets.store') }}">
            <input type="hidden" name="selectedTicket" value="{{isset($ticket)?$ticket->selectedTicket:''}}">
            <input type="hidden" name="selectedVisit" value="{{isset($ticket)?$ticket->selectedVisit:''}}">
            <input type="hidden" name="selectedOrder" value="{{isset($ticket)?$ticket->selectedOrder:''}}">
            <input type="hidden" name="selectedCalls" value="{{isset($ticket)?$ticket->selectedCalls:''}}">
            <input type="hidden" name="call_id"
                   value="{{isset($call)?$call->id:null}}">

            <div class="d-flex flex-column flex-md-row rounded border p-10" bis_skin_checked="1">
                <ul class="nav nav-tabs nav-pills flex-row border-0 flex-md-column me-5 mb-3 mb-md-0 fs-6 min-w-lg-200px"
                    role="tablist">
                    <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                        <a class="nav-link w-100 active btn btn-flex btn-active-light-success text-success-emphasis"
                           data-bs-toggle="tab"
                           href="#kt_vtab_ticket" aria-selected="true" role="tab">
                            {{__('Ticket')}}

                        </a>
                    </li>

                    <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                        <a class="nav-link w-100  btn-active-light-info text-info-emphasis btn btn-flex"
                           data-bs-toggle="tab"
                           href="#kt_vtab_orders" role="tab">
                            {{__('Orders')}}(<span id="ordersCount"></span>)

                        </a>
                    </li>
                    <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                        <a class="nav-link w-100  btn-active-light-warning text-warning-emphasis btn btn-flex"
                           data-bs-toggle="tab"
                           href="#kt_vtab_calls" role="tab">
                            {{__('Calls')}}(<span id="callsCount"></span>)

                        </a>
                    </li>
                    <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                        <a class="nav-link w-100  btn-active-light-primary text-primary-emphasis btn btn-flex"
                           data-bs-toggle="tab"
                           href="#kt_vtab_whatsapp" role="tab">
                            {{__('Whatsapp')}}

                        </a>
                    </li>
                    <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                        <a class="nav-link w-100  btn-active-light-dark btn text-dark-emphasis btn-flex"
                           data-bs-toggle="tab"
                           href="#kt_vtab_visits" role="tab">
                            {{__('Visits')}}(<span id="visitCount"></span>)

                        </a>
                    </li>
                    <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                        <a class="nav-link w-100  btn-active-light-dark btn text-dark-emphasis btn-flex"
                           data-bs-toggle="tab"
                           href="#kt_vtab_tickets" role="tab">
                            {{__('Tickets')}}(<span id="ticketsCount"></span>)

                        </a>
                    </li>
                    <li class="nav-item w-100 me-0 mb-md-2" role="presentation">
                        <a class="nav-link w-100  btn-active-light-warning btn text-warning-emphasis btn-flex"
                           data-bs-toggle="tab"
                           href="#kt_vtab_returns" role="tab">
                            {{__('Returns')}}(<span id="returnsCount"></span>)

                        </a>
                    </li>


                </ul>

                <div class="tab-content  table-responsive" id="myTabContent" bis_skin_checked="1">
                    <div class="tab-pane  table-responsive fade show active" id="kt_vtab_ticket" role="tabpanel"
                         bis_skin_checked="1">
                        @include('tickets.form')


                    </div>

                    <div class="tab-pane  table-responsive fade" id="kt_vtab_orders" role="tabpanel"
                         bis_skin_checked="1">
                        <div id="showOrders">
                            @include('tickets.orders')
                        </div>
                    </div>

                    <div class="tab-pane  table-responsive fade" id="kt_vtab_calls" role="tabpanel"
                         bis_skin_checked="1">
                        <div id="showCalls">
                            @include('tickets.calls')
                        </div>
                    </div>

                    <div class="tab-pane  table-responsive fade" id="kt_vtab_whatsapp" role="tabpanel"
                         bis_skin_checked="1">
                        <div id="showWhatsApp">
                            @include('tickets.whatsapp')
                        </div>
                    </div>

                    <div class="tab-pane  table-responsive fade" id="kt_vtab_visits" role="tabpanel"
                         bis_skin_checked="1">
                        <div id="showVisits">
                            @include('tickets.visits')
                        </div>

                    </div>
                    <div class="tab-pane  table-responsive fade" id="kt_vtab_tickets" role="tabpanel"
                         bis_skin_checked="1">
                        <div id="showTickets" class="table-responsive">
                            @include('tickets.tickets')
                        </div>

                    </div>

                    <div class="tab-pane  table-responsive fade" id="kt_vtab_returns" role="tabpanel"
                         bis_skin_checked="1">
                        <div id="showReturns">

                        </div>
                    </div>


                    <div class="row mt-5 my-10 @if(isset($ticket)&&$ticket->selectedOrder)  @else d-none @endif"
                         id="selectOrder">
                        <button type="button" class="btn btn-warning">
                            {{__('Orders')}} <span class="badge badge-light" id="selectedOrdersRowsCount"></span>
                            <span class="sr-only">{{__('Orders')}}<</span>
                        </button>
                        <div class="col-md-12 ">

                            <table class="table table-bordered align-middle table-row-dashed table-responsive"
                                   id="kt_table_orderHistory_selected">
                                <!--begin::Table head-->
                                <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                    <th class="min-w-100px all">{{__('SN')}}</th>
                                    <th class="min-w-100px all">{{__('Employee Name')}}</th>
                                    <th class="min-w-100px all">{{__('Restaurant Name')}}</th>
                                    <th class="min-w-100px all">{{__('Branch Name')}}</th>
                                    <th class="min-w-100px all">{{__('Order #')}}</th>
                                    <th class="min-w-100px all">{{__('Client Name')}}</th>
                                    <th class="min-w-100px all">{{__('Client Mobile # 1')}}</th>
                                    <th class="min-w-100px all">{{__('Client Mobile 2')}}</th>
                                    <th class="min-w-100px all">{{__('City')}}</th>
                                    <th class="min-w-100px all">{{__('Sub Destination')}}</th>
                                    <th class="min-w-100px all">{{__('Delivery Type')}}</th>
                                    <th class="min-w-100px all">{{__('Payment Type')}}</th>
                                    <th class="min-w-100px all">{{__('Order Create Date')}}</th>
                                    <th class="min-w-100px all">{{__('Order Create Time')}}</th>
                                    <th class="min-w-100px all">{{__('Expected Prep Time')}}</th>
                                    <th class="min-w-100px all">{{__('Captain Pickup Time')}}</th>
                                    <th class="min-w-200px all all">{{__('Captain Name')}}</th>
                                    <th class="min-w-200px  all">{{__('Mobile')}}</th>
                                    <th class="min-w-200px  all">{{__('Details')}}</th>
                                    <th class="min-w-100px all ">{{__('Delivery Status')}}</th>


                                </tr>
                                <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->

                            </table>

                        </div>
                    </div>
                    <div class="row mt-5 my-10 @if(isset($ticket)&&$ticket->selectedTicket)  @else d-none @endif"
                         id="selectTicket">
                        <button type="button" class="btn btn-warning">
                            {{__('Tickets')}} <span class="badge badge-light" id="selectedTicketsRowsCount"></span>
                            <span class="sr-only">{{__('Tickets')}}<</span>
                        </button>
                        <div class="col-md-12 ">

                            <table class="table table-bordered align-middle table-row-dashed table-responsive"
                                   id="kt_table_ticketHistory_selected">
                                <!--begin::Table head-->
                                <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                    <th class="min-w-100px all">{{__('SN')}}</th>
                                    <th class="min-w-100px all">{{__('Date')}}</th>

                                    <th class="min-w-100px all">{{__('Ticket Number')}}</th>
                                    <th class="min-w-100px all">{{__('Type')}}</th>
                                    <th class="min-w-100px all">{{__('Name')}}</th>
                                    <th class="min-w-100px all">{{__('Telephone')}}</th>
                                    <th class="min-w-100px all">{{__('email')}}</th>
                                    <th class="min-w-100px all">{{__('City')}}</th>
                                    <th class="min-w-100px all">{{__('Purpose')}}</th>

                                    <th class="min-w-100px all">{{__('Priority')}}</th>
                                    <th class="min-w-100px all">{{__('Status')}}</th>

                                </tr>
                                <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->

                            </table>

                        </div>
                    </div>
                    <div class="row mt-5   my-10 @if(isset($ticket)&&$ticket->selectedCalls)  @else d-none @endif"
                         id="selectCalls">
                        <button type="button" class="btn btn-primary">
                            {{__('Calls')}} <span class="badge badge-light" id="selectedCallsRowsCount"></span>
                            <span class="sr-only">{{__('Calls')}}<</span>
                        </button>

                        <div class="col-md-12">

                            <table class="table table-bordered align-middle table-row-dashed table-responsive"
                                   id="kt_table_callHistory_selected">
                                <!--begin::Table head-->
                                <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                    <th class="min-w-125px">ID</th>
                                    <th class="min-w-125px">Date</th>
                                    <th class="min-w-125px">From</th>
                                    <th class="min-w-125px">To</th>
                                    <th class="min-w-125px">Duration (SEC)</th>
                                    <th class="min-w-125px">Status</th>
                                    <th class="min-w-125px">Type</th>
                                    <th class="min-w-125px">Record</th>
                                </tr>
                                <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->

                            </table>

                        </div>
                    </div>
                    <div class="row  mt-5  my-10  @if(isset($ticket)&&$ticket->selectedVisit)  @else d-none @endif "
                         id="selectVisits">
                        <button type="button" class="btn btn-info">
                            {{__('Visits')}} <span class="badge badge-light" id="selectedVisitsRowsCount"></span>
                            <span class="sr-only">{{__('Visits')}}<</span>
                        </button>

                        <div class="col-md-12">

                            <table class="table table-bordered align-middle table-row-dashed table-responsive"
                                   id="kt_table_visitHistory_selected">
                                <!--begin::Table head-->
                                <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-100px all">{{__('SN')}}</th>
                                    <th class="min-w-100px all">{{__('Max Visit Date')}}</th>
                                    <th class="min-w-100px all">{{__('Date')}}</th>
                                    <th class="min-w-100px all">{{__('Time')}}</th>

                                    <th class="min-w-100px all">{{__('Visit Number')}}</th>
                                    <th class="min-w-100px all">{{__('Type')}}</th>
                                    <th class="min-w-100px all">{{__('Name')}}</th>
                                    <th class="min-w-100px all">{{__('Telephone')}}</th>

                                    <th class="min-w-100px all">{{__('City')}}</th>
                                    <th class="min-w-100px all">{{__('Period')}}</th>
                                    <th class="min-w-100px all">{{__('Category')}}</th>
                                    <th class="min-w-100px all">{{__('Employee')}}</th>
                                    <th class="min-w-100px all">{{__('Rating_Company')}}</th>
                                    <th class="min-w-100px all">{{__('Rating_Captin')}}</th>

                                </tr>
                                <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->

                            </table>

                        </div>

                    </div>

                </div>


            </div>

            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-ticket-modal-action="cancel"
                        data-bs-dismiss="modal">{{__('Discard')}}
                </button>
                <button type="submit" class="btn btn-primary" data-kt-ticket-modal-action="submit">
                    <span class="indicator-label">{{__('Submit')}}</span>
                    <span class="indicator-progress">{{__('Please wait...')}}
                          <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Actions-->
        </form>

        <!--end::Form-->
    </div>
    <!--end::Modal body-->
</div>
<!--end::Modal content-->




