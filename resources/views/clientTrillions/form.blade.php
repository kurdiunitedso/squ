<div class="card mb-5 mb-xl-10" id="kt_clientTrillion_details_view">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ isset($clientTrillion) ? $clientTrillion->name  : __('Creating New client Trillion') }}
                - {{ __('Details')}}</h3>
        </div>
        <!--end::Card title-->
        <div class="card-toolbar">
            <div class="align-items-center d-flex flex-row me-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="active" name="active_c"
                    @isset($clientTrillion)
                        @checked($clientTrillion->active == 1)

                        @endisset>
                    <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                           for="status">  {{ __('Active') }}</label>
                </div>
            </div>

        </div>
    </div>
    <!--begin::Card header-->

    <!--begin::Card body-->
    <div class="card-body p-9">
        <div class="row">
            <input type="hidden" name="facility_id" value="{{isset($facility)?$facility->id:null}}">
            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2 required"
                           data-input-name="{{__('Name Ar')}}">{{__('Name Ar ')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0 "
                           placeholder=""
                           value="{{ isset($clientTrillion) ? $clientTrillion->name : (isset($call)?$call->name:(isset($facility)?$facility->name:null)) }}"/>
                    <!--end::Input-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2 required"
                           data-input-name="{{__('Name En')}}">{{__('Name En')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="name_en" class="form-control form-control-solid mb-3 mb-lg-0"
                           placeholder=""
                           value="{{ isset($clientTrillion) ? $clientTrillion->name_en : (isset($call)?$call->name_en:(isset($facility)?$facility->name_en:null)) }}"/>
                    <!--end::Input-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2 "
                           data-input-name="{{__('Name H')}}">{{__('Name H')}}</label>
                    <!--hd::Label-->
                    <!--begin::Input-->
                    <input type="text" name="name_h" class="form-control form-control-solid mb-3 mb-lg-0 "
                           placeholder=""
                           value="{{ isset($clientTrillion) ? $clientTrillion->name_h : (isset($call)?$call->name_h:null) }}"/>
                    <!--hd::Input-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2 required"
                           data-input-name="{{__('Representative Name')}}">{{__('Representative Name')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="representative_name" class="form-control form-control-solid mb-3 mb-lg-0"
                           placeholder=""
                           value="{{ isset($clientTrillion) ? $clientTrillion->representative_name : (isset($call)?$call->representative_name:(isset($facility)?$facility->name:null)) }}"/>
                    <!--end::Input-->
                </div>
            </div>
            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2"
                           data-input-name="{{__('Registration Name')}}">{{__('Registration Name')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="registration_name" class="form-control form-control-solid mb-3 mb-lg-0"
                           placeholder=""
                           value="{{ isset($clientTrillion) ? $clientTrillion->registration_name : (isset($call)?$call->registration_name:(isset($facility)?$facility->name:null)) }}"/>
                    <!--end::Input-->
                </div>
            </div>
            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2 "
                           data-input-name="{{__('Registration Number')}}">{{__('Registration Number ')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="registration_number" class="form-control form-control-solid mb-3 mb-lg-0"
                           placeholder=""
                           value="{{ isset($clientTrillion) ? $clientTrillion->registration_number : (isset($call)?$call->registration_number:(isset($facility)?$facility->facility_id:null)) }}"/>
                    <!--end::Input-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2 required" data-input-name="Country">
                        {{ __('Country') }}</label>
                    <!--end::Label-->
                    <!--begin::Input-->

                    <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                            name="country_id"
                            data-placeholder="Select an option">
                        <option></option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}"
                            @isset($clientTrillion)
                                @selected($clientTrillion->country_id == $country->id)
                                @endisset>
                                {{ $country->name }}</option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2 required" data-input-name="City">
                        {{ __('City') }}</label>
                    <!--end::Label-->
                    <!--begin::Input-->

                    <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                            name="city_id"
                            data-placeholder="Select an option">
                        <option></option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}"
                            @isset($clientTrillion)
                                @selected($clientTrillion->city_id == $city->id)
                                @endisset>
                                {{ $city->name }}</option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="fv-row mb-4">
                    <!--begin::Label-->
                    <label class=" fw-semibold fs-6 mb-2 ">{{__('Type')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                            name="company_type" id="category" data-placeholder="Select an option">
                        <option></option>
                        @foreach ($company_types as $t)
                            <option value="{{ $t->id }}"
                            @if (isset($clientTrillion))
                                @selected($clientTrillion->company_type ==$t->id)
                                @endif>
                                {{ $t->name }}</option>
                        @endforeach
                    </select>
                    <!--end::Input-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2 "
                           data-input-name="{{__('Address')}}">{{__('Client Trillion Address')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="address" class="form-control form-control-solid mb-3 mb-lg-0"
                           placeholder="" value="{{ isset($clientTrillion) ? $clientTrillion->address : (isset($facility)?$facility->address:null) }}"/>
                    <!--end::Input-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="fv-row mb-7 ">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2 required"
                           data-input-name="Telephone">{{__('Telephone')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="telephone" class="form-control form-control-solid mb-3 mb-lg-0"
                           placeholder=""
                           value="{{ isset($clientTrillion) ? $clientTrillion->telephone : (isset($call)?$call->telephone:(isset($facility)?$facility->telephone:null))  }}"/>
                    <!--end::Input-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2" data-input-name="Fax">{{__('Fax')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="fax" class="form-control form-control-solid mb-3 mb-lg-0"
                           placeholder=""
                           value="{{ isset($clientTrillion) ? $clientTrillion->fax : (isset($call)?$call->fax:(isset($facility)?$facility->fax:null))  }}"/>
                    <!--end::Input-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2 " data-input-name="Fax">{{__('Email')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                           placeholder=""
                           value="{{ isset($clientTrillion) ? $clientTrillion->email : (isset($call)?$call->email:(isset($facility)?$facility->email:null))  }}"/>
                    <!--end::Input-->
                </div>
            </div>

        </div>
    </div>
</div>

<!--end::Card body-->



