<!--begin::Card header-->
<div class="card-header">
    <!--begin::Card title-->
    <div class="card-title m-0">
        <h3 class="fw-bold m-0">{{__('Marketing Agency Details')}}</h3>
    </div>
    <!--end::Card title-->
    <div class="card-toolbar">


        <div class="align-items-center d-flex flex-row me-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="active" name="active_c"
                       @if(isset($marketingAgency))
                           @checked($marketingAgency->active == 1)
                           @if($marketingAgency->active)
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
                       placeholder="" value="{{ isset($marketingAgency) ? $marketingAgency->name : '' }}"/>
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
                       placeholder="" value="{{ isset($marketingAgency) ? $marketingAgency->name_en : '' }}"/>
                <!--end::Input-->
            </div>
        </div>
 {{--       <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2" data-input-name="Name">{{ __('Registration No') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="registration_no" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($marketingAgency) ? $marketingAgency->registration_no : '' }}"/>
                <!--end::Input-->
            </div>
        </div>--}}
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
                        @isset($marketingAgency)
                            @selected($marketingAgency->type_id == $type->id)
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
                <label class="required fw-semibold fs-6 mb-2" data-input-name="City">
                    {{ __('City') }}</label>
                <!--end::Label-->
                <!--begin::Input-->

                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                        name="city_id"
                        data-placeholder="Select an option">
                    <option></option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}"
                        @isset($captin)
                            @selected($captin->city_id == $city->id)
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
                <label class="required fw-semibold fs-6 mb-2" data-input-name="Price">{{ __('Telephone') }}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="telephone" class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder="" value="{{ isset($marketingAgency) ? $marketingAgency->telephone : '' }}"/>
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
                       placeholder="" value="{{ isset($marketingAgency) ? $marketingAgency->email : '' }}"/>
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
                       placeholder="" value="{{ isset($marketingAgency) ? $marketingAgency->fax : '' }}"/>
                <!--end::Input-->
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('Facebook')}}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="facebook_address"
                       class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder=""
                       value="{{ isset($marketingAgency) ? $marketingAgency->facebook_address : '' }}"/>
                <!--end::Input-->
            </div>
        </div>

        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('Instagram')}}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="instagram_address"
                       class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder=""
                       value="{{ isset($marketingAgency) ? $marketingAgency->instagram_address : '' }}"/>
                <!--end::Input-->
            </div>
        </div>

        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('TikTok')}}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="tiktok_address"
                       class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder=""
                       value="{{ isset($marketingAgency) ? $marketingAgency->tiktok_address : '' }}"/>
                <!--end::Input-->
            </div>
        </div>

        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fw-semibold fs-6 mb-2" data-input-name="">  {{__('Manager Name')}}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="manager_name"
                       class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder=""
                       value="{{ isset($marketingAgency) ? $marketingAgency->manager_name : '' }}"/>
                <!--end::Input-->
            </div>
        </div>

        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('Employees')}}
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="employees"
                       class="form-control form-control-solid mb-3 mb-lg-0"
                       placeholder=""
                       value="{{ isset($marketingAgency) ? $marketingAgency->employees : '' }}"/>
                <!--end::Input-->
            </div>
        </div>

        <div class="col-md-4">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-semibold fs-6 mb-2"
                       data-input-name="Size">{{ __('Size') }}</label>
                <!--end::Label-->
                <!--begin::Input-->

                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                        name="size_id"
                        data-placeholder="Select an option">
                    <option></option>
                    @foreach ($sizes as $size)
                        <option value="{{ $size->id }}"
                        @isset($marketingAgency)
                            @selected($marketingAgency->size_id == $size->id)
                            @endisset>
                            {{ $size->name }}</option>
                    @endforeach
                </select>
                <!--end::Input-->
            </div>
        </div>

    </div>
</div>






