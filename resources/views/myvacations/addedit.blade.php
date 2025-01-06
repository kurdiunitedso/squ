<!--begin::Modal content-->
<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_vacation_header">
        <!--begin::Modal preparation_time-->
        <h2 class="fw-bold">{{ __('Add Vacation') }}</h2>
        <!--end::Modal preparation_time-->
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
    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <!--begin::Form-->

        <!--begin::Scroll-->
        <form id="kt_modal_add_vacation_form" class="form"
              data-editMode="{{ isset($vacation) ? 'enabled' : 'disabled' }}"
              action="{{ isset($vacation) ? route('myvacations.update', ['vacation' => $vacation->id]) : route('myvacations.store') }}">
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_vacation_scroll" data-kt-scroll="true"
                 data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                 data-kt-scroll-dependencies="#kt_modal_add_vacation_header"
                 data-kt-scroll-wrappers="#kt_modal_add_vacation_scroll" data-kt-scroll-offset="300px">

                @if(isset($vacation))
                    <input type="hidden" name="vacation_id" value="{{$vacation->id}}">
                @endif
                <!--begin::Input group-->
                <div class="row">

                 <input type="hidden" value="{{$employee->id}}" name="employee_id">

                    <div class="col-md-12">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2" data-input-name="City">
                                {{ __('Type') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->

                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="type"
                                    data-placeholder="Select an option">
                                <option></option>
                                @foreach ($types as $s)
                                    <option value="{{ $s->id }}"
                                    @isset($vacation)
                                        @selected($vacation->type == $s->id)
                                        @endisset>
                                        {{ $s->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2"
                                   data-input-name="Address">{{ __('Valid From') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="from_date"
                                   class="form-control date-flatpickr2 form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($vacation)?$vacation->from_date:null }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2 "
                                   data-input-name="Address">{{ __('Valid To') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="to_date"
                                   class="form-control  date-flatpickr22 form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($vacation)?$vacation->to_date:null }}"/>
                            <!--end::Input-->
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2"
                                   data-input-name="{{__('reason')}}">{{__('Reason')}}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="reason" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($vacation) ? $vacation->reason : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2"
                                   data-input-name="{{__('contact_no')}}">{{__('contact_no')}}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="contact_no" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($vacation) ? $vacation->contact_no : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2"
                                   data-input-name="{{__('comment')}}">{{__('comment')}}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="comment" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($vacation) ? $vacation->comment : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                </div>


                <!--end::Input group-->
            </div>
            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-vacations-modal-action="cancel"
                        data-bs-dismiss="modal">{{ __('Discard') }}
                </button>
                <button type="submit" class="btn btn-primary" data-kt-vacations-modal-action="submit">
                    <span class="indicator-label">{{ __('Submit') }}</span>
                    <span class="indicator-progress">{{ __('Please wait...') }}
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
