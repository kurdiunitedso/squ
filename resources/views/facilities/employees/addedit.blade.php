<!--begin::Modal content-->
<div class="modal-content">
    <!--begin::Modal header-->
    <div class="modal-header" id="kt_modal_add_employee_header">
        <!--begin::Modal title-->
        <h2 class="fw-bold">{{ __('Add Employee') }}</h2>
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
    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <!--begin::Form-->

        <!--begin::Scroll-->
        <form id="kt_modal_add_employee_form" class="form"
              data-editMode="{{ isset($employee) ? 'enabled' : 'disabled' }}"
              action="{{ isset($employee) ? route('facilities.employees.update', ['employee' => $employee->id]) : route('facilities.employees.store') }}">
            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_employee_scroll" data-kt-scroll="true"
                 data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                 data-kt-scroll-dependencies="#kt_modal_add_employee_header"
                 data-kt-scroll-wrappers="#kt_modal_add_employee_scroll" data-kt-scroll-offset="300px">
                <input type="hidden" name="facility_id" value="{{$facility->id}}">
                @if(isset($employee))
                    <input type="hidden" name="employee_id" value="{{$employee->id}}">
                @endif
                <!--begin::Input group-->
                <div class="row">
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Name">
                                {{ __('Name') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($employee) ? $employee->name : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Mobile">
                                {{ __('Email') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($employee) ? $employee->email : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Mobile">
                                {{ __('Mobile') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="mobile" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($employee) ? $employee->mobile : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Mobile">
                                {{ __('Whatsapp') }}
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="whatsapp" class="form-control form-control-solid mb-3 mb-lg-0"
                                   placeholder="" value="{{ isset($employee) ? $employee->whatsapp : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="title">
                                {{ __('Title') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->

                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="title"
                                    data-placeholder="Select an option">
                                <option></option>
                                @foreach ($titles as $title)
                                    <option value="{{ $title->id }}"
                                    @isset($employee)
                                        @selected($employee->title == $title->id)
                                        @endisset>
                                        {{ $title->name }}</option>
                                @endforeach
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
                                    @isset($employee)
                                        @selected($employee->city_id == $city->id)
                                        @endisset>
                                        {{ $city->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-semibold fs-6 mb-2" data-input-name="Branch">
                                {{ __('Branch') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->

                            <select class="form-select form-select-solid mb-3 mb-lg-0 " data-control="select2"
                                    name="facility_branch_id"
                                    data-placeholder="Select an option">
                                <option></option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                    @isset($employee)
                                        @selected($employee->facility_branch_id  == $branch->id)
                                        @endisset>
                                        {{ $branch->address }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>

               {{--     <div class="col-md-4 d-none">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2" data-input-name="Status">
                                {{ __('Status') }}</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                                    name="status" data-placeholder="Select an option">
                                <option></option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}"
                                    @isset($employee)
                                        @selected($employee->status == $status->id)
                                        @endisset>
                                        {{ $status->name }}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                    </div>--}}

                </div>

                <!--end::Input group-->
            </div>
            <!--end::Scroll-->
            <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3" data-kt-employees-modal-action="cancel"
                        data-bs-dismiss="modal">{{ __('Discard') }}
                </button>
                <button type="submit" class="btn btn-primary" data-kt-employees-modal-action="submit">
                    <span class="indicator-label">{{ __('Submit') }}</span>
                    <span class="indicator-progress">Please wait...
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
