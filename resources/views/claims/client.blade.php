<div class="card mb-5 mb-xl-10" id="kt_client_details_view">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title m-0 w-600px">
            <select class="form-select form-select-solid mb-3 mb-lg-0" id="client_id" data-control="select2"
                    name="client_id"
                    data-placeholder="Select Client">
                <option></option>
                @foreach ($clients as $c)
                    <option value="{{ $c->id }}"
                    @isset($client)
                        @selected($client->id == $c->id)
                        @endisset>
                        {{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <!--end::Card title-->

    </div>
    <!--begin::Card header-->

    <!--begin::Card body-->
    <div class="card-body p-9">
        <div class="row">

            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2 required"
                           data-input-name="{{__('Name Ar')}}">{{__('Name Ar ')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0 required"
                           placeholder=""
                           value="{{ isset($client) ? $client->name : (isset($call)?$call->name:null) }}"/>
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
                           value="{{ isset($client) ? $client->name_en : (isset($call)?$call->name_en:null) }}"/>
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
                           value="{{ isset($client) ? $client->name_h : (isset($call)?$call->name_h:null) }}"/>
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
                           value="{{ isset($client) ? $client->representative_name : null }}"/>
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
                           value="{{ isset($client) ? $client->registration_name : (isset($call)?$call->registration_name:null) }}"/>
                    <!--end::Input-->
                </div>
            </div>
            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2 required"
                           data-input-name="{{__('Registration Number')}}">{{__('Registration Number ')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="registration_number" class="form-control form-control-solid mb-3 mb-lg-0"
                           placeholder=""
                           value="{{ isset($client) ? $client->registration_number : (isset($call)?$call->registration_number:null) }}"/>
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
                            @isset($client)
                                @selected($client->country_id == $country->id)
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
                            @isset($client)
                                @selected($client->city_id == $city->id)
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
                    <label class=" fw-semibold fs-6 mb-2 required">{{__('Type')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                            name="company_type" id="category" data-placeholder="Select an option">
                        <option></option>
                        @foreach ($company_types as $t)
                            <option value="{{ $t->id }}"
                            @if (isset($client))
                                @selected($client->company_type ==$t->id)
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
                    <label class="fw-semibold fs-6 mb-2 required"
                           data-input-name="{{__('Address')}}">{{__('Client Trillion Address')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="address" class="form-control form-control-solid mb-3 mb-lg-0"
                           placeholder="" value="{{ isset($client) ? $client->address : '' }}"/>
                    <!--end::Input-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="fv-row mb-7 ">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2 required" data-input-name="Telephone">{{__('Telephone')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="telephone" class="form-control form-control-solid mb-3 mb-lg-0"
                           placeholder=""
                           value="{{ isset($client) ? $client->telephone : (isset($call)?$call->telephone:null)  }}"/>
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
                           value="{{ isset($client) ? $client->fax : (isset($call)?$call->fax:null)  }}"/>
                    <!--end::Input-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fw-semibold fs-6 mb-2 required" data-input-name="Fax">{{__('Email')}}</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                           placeholder=""
                           value="{{ isset($client) ? $client->email : (isset($call)?$call->email:null)  }}"/>
                    <!--end::Input-->
                </div>
            </div>

        </div>


    </div>

</div>

<!--end::Card body-->



