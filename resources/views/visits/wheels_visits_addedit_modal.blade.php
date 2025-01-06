<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_visit_header">
        <!--begin::Modal title-->
        <h2 class="fw-bold">{{__('Add Visit')}}</h2>
        <!--end::Modal title-->
        <!--begin::Close-->
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
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
        <!--end::Close-->
    </div>
    <!--end::Modal header-->
    <!--begin::Modal body-->
    <div class="modal-body scroll-y mx-5 my-7">
        <!--begin::Form-->

        <!--begin::Scroll-->
        <form id="kt_modal_add_visit_form" class="form"
              data-editMode="{{ isset($visit) ? 'enabled' : 'disabled' }}"
              action="{{ isset($visit) ? route('visits.update', ['visit' => $visit->id]) : route('visits.store') }}">
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_visit_scroll"
                 data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                 data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_visit_header"
                 data-kt-scroll-wrappers="#kt_modal_add_visit_scroll" data-kt-scroll-offset="300px">
                <!--begin::Input group-->
                <div class="row">
                    {{--     <div class="col-md-4">
                             <div class="fv-row mb-7">
                                 <!--begin::Label-->
                                 <label class=" fw-semibold fs-6 mb-2"
                                        data-input-name="Last Visit Date">{{__('Max Visit Date')}}
                                 </label>
                                 <!--end::Label-->
                                 <!--begin::Input-->
                                 <div class="position-relative d-flex align-items-center">
                                     <!--begin::Icon-->
                                     <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                     <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                  xmlns="http://www.w3.org/2000/svg">
                                                 <path opacity="0.3"
                                                       d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                                       fill="currentColor"></path>
                                                 <path
                                                     d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                                     fill="currentColor"></path>
                                                 <path
                                                     d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                     fill="currentColor"></path>
                                             </svg>
                                         </span>
                                     <!--end::Svg Icon-->
                                     <!--end::Icon-->
                                     <!--begin::Datepicker-->
                                     <input type="text" name="last_date"
                                            class="form-control form-control-solid ps-12 date-flatpickr flatpickr-input mb-3 mb-lg-0"
                                            autocomplete="off" placeholder=""
                                            value="{{ isset($visit)
                                                 ? ($visit->last_date
                                                     ? \Carbon\Carbon::parse($visit->last_date)->format('Y-m-d')
                                                     : old('last_date'))
                                                 : old('last_date') }}"/>
                                     <!--end::Datepicker-->
                                 </div>

                                 <!--end::Input-->
                             </div>
                         </div>--}}
                    <input type="hidden" name="visit_request_id"
                           value="{{isset($visitRequest)?$visitRequest->id:null}}">
                    <input type="hidden" name="call_id"
                           value="{{isset($call)?$call->id:null}}">

                    <input type="hidden" class="d-none" name="visit_time" value="{{ isset($visit)? $visit->visit_time:\Carbon\Carbon::now()->format('H:i') }}"/>
                    <input type="hidden" class="d-none " name="visit_date" value="{{ isset($visit)? $visit->visit_time:\Carbon\Carbon::now()->format('Y-m-d') }}"/>
                    <input type="hidden" class="d-none " name="last_date" value="{{ isset($visit)? $visit->last_date:(isset($visitRequest)?$visitRequest->last_date:null) }}"/>
             {{--       <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Visit Date">{{__('Date')}}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="position-relative d-flex align-items-center">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                  d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                                  fill="currentColor"></path>
                                            <path
                                                d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Datepicker-->
                                <input type="text" name="visit_date"
                                       class="form-control form-control-solid ps-12 date-flatpickr flatpickr-input mb-3 mb-lg-0"
                                       autocomplete="off" placeholder=""
                                       value="{{ isset($visit)
                                            ? ($visit->visit_date
                                                ? \Carbon\Carbon::parse($visit->visit_date)->format('Y-m-d')
                                                : old('visit_date'))
                                            : \Carbon\Carbon::now()->format('Y-m-d') }}"/>
                                <!--end::Datepicker-->
                            </div>

                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Visit time">{{__('Time')}}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="position-relative d-flex align-items-center">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3"
                                                  d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                                  fill="currentColor"></path>
                                            <path
                                                d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                                fill="currentColor"></path>
                                            <path
                                                d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Datepicker-->
                                <input type="text" name="visit_time"
                                       class="form-control form-control-solid ps-12 time-flatpickr flatpickr-input mb-3 mb-lg-0"
                                       autocomplete="off" placeholder=""
                                       value="{{ isset($visit)
                                            ? ($visit->visit_time
                                                ? \Carbon\Carbon::parse($visit->visit_time)->format('H:i')
                                                : old('visit_date'))
                                            : \Carbon\Carbon::now()->format('H:i') }}"/>
                                <!--end::Datepicker-->
                            </div>
                            <!--end::Input-->
                        </div>
                    </div>--}}


                    <div class="col-md-4">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2">{{__('Department')}}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="department" id="department" data-placeholder="Select an option">
                                <option></option>
                                @foreach ($ticket_type as $t)
                                    <option value="{{ $t->id }}"
                                    @if (isset($visit))
                                        @selected($visit->department ==$t->id)
                                        @elseif(isset($visitRequest))
                                        @selected($visitRequest->department ==$t->id)
                                        @endif>
                                        {{ $t->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2">{{__('Employee')}}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="employee" id="employee" data-placeholder="Select an option">
                                <option></option>
                                @foreach ($EMPLOYEES as $t)
                                    <option value="{{ $t->id }}"
                                    @if (isset($visit))
                                        @selected($visit->employee ==$t->id)
                                        @elseif(isset($visitRequest))
                                        @selected($visitRequest->employee ==$t->id)
                                        @else
                                        @selected(\Illuminate\Support\Facades\Auth::user()->id ==$t->id)
                                        @endif>
                                        {{ $t->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">{{__('Name')}} </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="visit_name" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="{{__('Name')}}"
                                   value="{{ isset($visit) ? $visit->visit_name : (isset($visitRequest)?$visitRequest->visit_name:(isset($call)?$call->name:null)) }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    {{--           <div class="col-md-4">
                                   <div class="fv-row mb-4">
                                       <!--begin::Label-->
                                       <label class=" fw-semibold fs-6 mb-2">{{__('Visit Number')}} </label>
                                       <!--end::Label-->
                                       <!--begin::Input-->
                                       <input type="text" name="visit_number" class="form-control form-control-solid mb-3 mb-lg-0"
                                              placeholder="{{__('Visit Number')}}"
                                              value="{{ isset($visit) ? $visit->visit_number : '' }}"/>
                                       <!--end::Input-->
                                   </div>
                               </div>--}}
                    <div class="col-md-4">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2">{{__('Category')}}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="visit_category" id="category" data-placeholder="Select an option">
                                <option></option>
                                @foreach ($category as $t)
                                    <option value="{{ $t->id }}"
                                    @if (isset($visit))
                                        @selected($visit->visit_category ==$t->id)
                                        @elseif(isset($visitRequest))
                                        @selected($visitRequest->visit_category ==$t->id)
                                        @endif>
                                        {{ $t->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2">{{__('Purpose')}}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="purpose" id="purpose" data-placeholder="Select an option">
                                <option></option>
                                @foreach ($purpose as $t)
                                    <option value="{{ $t->id }}"
                                    @if (isset($visit))
                                        @selected($visit->purpose ==$t->id)
                                        @elseif(isset($visitRequest))
                                        @selected($visitRequest->purpose ==$t->id)
                                        @endif>
                                        {{ $t->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2">{{__('Visit Type')}}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="type_id" id="type_id" data-placeholder="Select an option">
                                <option></option>
                                @foreach ($visit_type as $t)
                                    <option value="{{ $t->id }}"
                                    @if (isset($visit))
                                        @selected($visit->visit_type ==$t->id)
                                        @elseif(isset($visitRequest))
                                        @selected($visitRequest->visit_type ==$t->id)
                                        @endif>
                                        {{ $t->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>

                    {{--     <div class="col-md-4">
                             <div class="fv-row mb-4">
                                 <!--begin::Label-->
                                 <label class=" fw-semibold fs-6 mb-2">{{__('Period')}}</label>
                                 <!--end::Label-->
                                 <!--begin::Input-->
                                 <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                         name="type_id" id="period" data-placeholder="Select an option">
                                     <option></option>
                                     @foreach ($period as $t)
                                         <option value="{{ $t->id }}"
                                         @if (isset($visit))
                                             @selected($visit->period ==$t->id)
                                             @endif>
                                             {{ $t->name }}</option>
                                     @endforeach
                                 </select>
                                 <!--end::Input-->
                             </div>
                         </div>--}}

                    <div class="col-md-4">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2">{{__('Telephone')}}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="telephone" class="form-control form-control-solid mb-3 mb-lg-0"
                                   value="{{ isset($visit) ? $visit->telephone : (isset($visitRequest)?$visitRequest->telephone:(isset($call)?$call->telephone:'')) }}"/>
                            <!--end::Input-->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Has_call_center">
                                {{ __('Source') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="source"
                                    data-placeholder="Select an option">
                                <option></option>
                                <option value="CRM"
                                    @selected(!(isset($visit) &&$visit->source == 'Wheel'))
                                >
                                    {{ __('CRM') }}
                                </option>
                                <option value="Wheel"
                                        @selected(isset($visit) &&$visit->source == 'Wheel')
                                        @>
                                    {{ __('Wheel') }}
                                </option>

                            </select>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="City">
                                {{ __('City') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->

                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="city_id"
                                    data-placeholder="Select an option">
                                <option></option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                    @isset($visit)
                                        @selected($visit->city_id == $city->id)
                                        @endisset>
                                        {{ $city->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="separator my-10"></div>
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="City">
                                {{ __('Rate Company') }}</label>
                            <div class="rating">
                                <!--begin::Reset rating-->
                                <label class="btn btn-light fw-bold btn-sm rating-label me-3" for="kt_rating_2_input_0">
                                    Reset
                                </label>
                                <input class="rating-input" name="rate_company" value="0"
                                       @if(isset($visit) && $visit->rate_company>=0) checked @endif type="radio"
                                       id="kt_rating_2_input_0"/>
                                <!--end::Reset rating-->

                                <!--begin::Star 1-->
                                <label class="rating-label" for="kt_rating_2_input_1">
                                    <i class="ki-duotone ki-star fs-1"></i>
                                </label>
                                <input class="rating-input" name="rate_company" value="1"
                                       @if(isset($visit) && $visit->rate_company>=1) checked @endif type="radio"
                                       id="kt_rating_2_input_1"/>
                                <!--end::Star 1-->

                                <!--begin::Star 2-->
                                <label class="rating-label" for="kt_rating_2_input_2">
                                    <i class="ki-duotone ki-star fs-1"></i>
                                </label>
                                <input class="rating-input" name="rate_company" value="2"
                                       @if(isset($visit) && $visit->rate_company>=2) checked @endif  type="radio"
                                       id="kt_rating_2_input_2"/>
                                <!--end::Star 2-->

                                <!--begin::Star 3-->
                                <label class="rating-label" for="kt_rating_2_input_3">
                                    <i class="ki-duotone ki-star fs-1"></i>
                                </label>
                                <input class="rating-input" name="rate_company" value="3" type="radio"
                                       @if(isset($visit) && $visit->rate_company>=3) checked @endif
                                       id="kt_rating_2_input_3"/>
                                <!--end::Star 3-->

                                <!--begin::Star 4-->
                                <label class="rating-label" for="kt_rating_2_input_4">
                                    <i class="ki-duotone ki-star fs-1"></i>
                                </label>
                                <input class="rating-input" name="rate_company" value="4" type="radio"
                                       @if(isset($visit) && $visit->rate_company>=4) checked @endif
                                       id="kt_rating_2_input_4"/>
                                <!--end::Star 4-->

                                <!--begin::Star 5-->
                                <label class="rating-label" for="kt_rating_2_input_5">
                                    <i class="ki-duotone ki-star fs-1"></i>
                                </label>
                                <input class="rating-input" name="rate_company" value="5" type="radio"
                                       @if(isset($visit) && $visit->rate_company>=5) checked @endif
                                       id="kt_rating_2_input_5"/>
                                <!--end::Star 5-->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="City">
                                {{ __('Rate Captin') }}</label>
                            <div class="rating">
                                <!--begin::Reset rating-->
                                <label class="btn btn-light fw-bold btn-sm rating-label me-3"
                                       for="kkt_rating_2_input_0">
                                    Reset
                                </label>
                                <input class="rating-input" name="rate_captin" value="0"
                                       @if(isset($visit) && $visit->rate_captin>=0) checked @endif type="radio"
                                       id="kkt_rating_2_input_0"/>
                                <!--end::Reset rating-->

                                <!--begin::Star 1-->
                                <label class="rating-label" for="kkt_rating_2_input_1">
                                    <i class="ki-duotone ki-star fs-1"></i>
                                </label>
                                <input class="rating-input" name="rate_captin" value="1"
                                       @if(isset($visit) && $visit->rate_captin>=1) checked @endif type="radio"
                                       id="kkt_rating_2_input_1"/>
                                <!--end::Star 1-->

                                <!--begin::Star 2-->
                                <label class="rating-label" for="kkt_rating_2_input_2">
                                    <i class="ki-duotone ki-star fs-1"></i>
                                </label>
                                <input class="rating-input" name="rate_captin" value="2"
                                       @if(isset($visit) && $visit->rate_captin>=2) checked @endif  type="radio"
                                       id="kkt_rating_2_input_2"/>
                                <!--end::Star 2-->

                                <!--begin::Star 3-->
                                <label class="rating-label" for="kkt_rating_2_input_3">
                                    <i class="ki-duotone ki-star fs-1"></i>
                                </label>
                                <input class="rating-input" name="rate_captin" value="3" type="radio"
                                       @if(isset($visit) && $visit->rate_captin>=3) checked @endif
                                       id="kkt_rating_2_input_3"/>
                                <!--end::Star 3-->

                                <!--begin::Star 4-->
                                <label class="rating-label" for="kkt_rating_2_input_4">
                                    <i class="ki-duotone ki-star fs-1"></i>
                                </label>
                                <input class="rating-input" name="rate_captin" value="4" type="radio"
                                       @if(isset($visit) && $visit->rate_captin>=4) checked @endif
                                       id="kkt_rating_2_input_4"/>
                                <!--end::Star 4-->

                                <!--begin::Star 5-->
                                <label class="rating-label" for="kkt_rating_2_input_5">
                                    <i class="ki-duotone ki-star fs-1"></i>
                                </label>
                                <input class="rating-input" name="rate_captin" value="5" type="radio"
                                       @if(isset($visit) && $visit->rate_captin>=5) checked @endif
                                       id="kkt_rating_2_input_5"/>
                                <!--end::Star 5-->
                            </div>
                        </div>
                    </div>
                    <div class="separator my-10"></div>
                    <div class="col-md-12">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2">{{__('Details')}}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="details" class="form-control form-control-solid mb-3 mb-lg-0"
                                      placeholder="{{__('Details')}}"
                            >{{ isset($visit) ? $visit->details : '' }}</textarea>
                            <!--end::Input-->
                        </div>
                    </div>

                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
            </div>


            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-visit-modal-action="cancel"
                        data-bs-dismiss="modal">{{__('Discard')}}
                </button>
                <button type="submit" class="btn btn-primary" data-kt-visit-modal-action="submit">
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
