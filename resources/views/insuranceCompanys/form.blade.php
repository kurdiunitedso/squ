<!--begin::Card header-->
<div class="card-header">
    <!--begin::Card title-->
    <div class="card-title m-0">
        <h3 class="fw-bold m-0">{{__('Insurance Company Details')}}</h3>
    </div>
    <!--end::Card title-->
    <div class="card-toolbar">


        <div class="align-items-center d-flex flex-row me-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="active" name="active_c"
                       @if(isset($insuranceCompany))
                           @checked($insuranceCompany->active == 1)
                           @if($insuranceCompany->active)
                               value="on"
                       @else
                           value="off"
                       @endif

                       @else
                           value="off"
                    @endif>
                <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                       for="status">  {{ __('Active') }}</label>
            </div>
        </div>


    </div>
</div>
<!--begin::Card body-->
<div class="card-body p-9">
    <div class="row">
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Name') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($insuranceCompany) ? $insuranceCompany->name : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Name En') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="name_en" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($insuranceCompany) ? $insuranceCompany->name_en : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Registration No') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="registration_no" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($insuranceCompany) ? $insuranceCompany->registration_no : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2"
                       data-input-name="Type">{{ __('Type') }}</label>
                <!--end::Label-->
                <!--begin::Input-->

                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                        name="type_id"
                        data-placeholder="Select an option">
                    <option></option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}"
                        @isset($insuranceCompany)
                            @selected($insuranceCompany->type_id == $type->id)
                            @endisset>
                            {{ $type->name }}</option>
                    @endforeach
                </select>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2" data-input-name="Address">{{ __('Address') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="address" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($insuranceCompany) ? $insuranceCompany->address : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Telephone') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="telephone" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($insuranceCompany) ? $insuranceCompany->telephone : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Email') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($insuranceCompany) ? $insuranceCompany->email : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Fax') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="fax" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($insuranceCompany) ? $insuranceCompany->fax : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class=" fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Commission') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="number" name="commission" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($insuranceCompany) ? $insuranceCompany->commission : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
    </div>
</div>






