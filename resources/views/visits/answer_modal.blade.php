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
                <div class="row border border-success m-3 p-3 mb-3">
                    <input type="hidden" name="updateAnswer" value="1">
                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Date')}}: </h4>


                        <span style="font-size: 16px;">{{ isset($visit)
                                            ? ($visit->visit_date
                                                ? \Carbon\Carbon::parse($visit->visit_date)->format('Y-m-d')
                                                : old('visit_date'))
                                            : old('visit_date') }}</span>
                        <!--end::Datepicker-->
                    </div>

                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Time')}}: </h4>


                        <span style="font-size: 16px; ">{{ isset($visit)
                                            ? ($visit->visit_date
                                                ? \Carbon\Carbon::parse($visit->visit_date)->format('H:i')
                                                : old('visit_date'))
                                            : old('visit_date') }}</span>
                        <!--end::Datepicker-->
                    </div>
                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Status')}}: </h4>


                        <span style="font-size: 16px; ">{{$visit->statuses->name }}</span>
                        <!--end::Datepicker-->
                    </div>

                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Employee')}}: </h4>


                        <span style="font-size: 16px; ">{{$visit->employees->name }}</span>
                        <!--end::Datepicker-->
                    </div>

                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Name')}} : </h4>


                        <span style="font-size: 16px; ">{{ isset($visit) ? $visit->visit_name : '' }}</span>
                        <!--end::Datepicker-->
                    </div>


                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Visit Number')}} : </h4>


                        <span style="font-size: 16px; ">{{ isset($visit) ? $visit->visit_number : '' }}</span>
                        <!--end::Datepicker-->
                    </div>
                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Visit Type')}} : </h4>


                        <span style="font-size: 16px; ">{{ isset($visit) ? $visit->visit_types->name : '' }}</span>
                        <!--end::Datepicker-->
                    </div>

                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Period')}} : </h4>


                        <span style="font-size: 16px; ">{{ $visit->periods->name }}</span>
                        <!--end::Datepicker-->
                    </div>


                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Telephone')}} : </h4>


                        <span style="font-size: 16px; ">{{ isset($visit) ? $visit->telephone : '' }}</span>
                        <!--end::Datepicker-->
                    </div>

                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Email')}} : </h4>


                        <span style="font-size: 16px; ">{{ isset($visit) ? $visit->email : '' }}</span>
                        <!--end::Datepicker-->
                    </div>

                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('City')}} : </h4>


                        <span style="font-size: 16px; ">{{ isset($visit) ?  $visit->cities->name : '' }}</span>
                        <!--end::Datepicker-->
                    </div>
                    <div class="col-md-4 p-3 mb-3">

                        <h4 class="text-success">{{__('Source')}} : </h4>


                        <span style="font-size: 16px; ">{{ isset($visit) ? $visit->source : '' }}</span>
                        <!--end::Datepicker-->
                    </div>
                    <div class="separator separator-dashed my-6"></div>
                </div>
                <div class="row border border-success m-3  p-3 mb-3">
                    <div class="col-md-12">

                        <h4 class="text-success">{{__('Details')}} : </h4>


                        <span style="font-size: 16px; ">{{ isset($visit) ?  $visit->details : '' }}</span>
                        <!--end::Datepicker-->
                    </div>
                </div>
                <div class="row  m-3  p-3 mb-3">

              {{--      <div class="col-md-12">
                        <div class="fv-row mb-4">
                            <!--begin::Label-->
                            <h4 class="text-success">{{__('Answer')}} : </h4>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="visit_answer" class="form-control form-control-solid mb-3 mb-lg-0"
                                      placeholder="{{__('Answer')}}"
                            >{{ isset($visit) ? $visit->visit_answer : '' }}</textarea>
                            <!--end::Input-->
                        </div>
                    </div>--}}

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
