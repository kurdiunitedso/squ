<div class="row">
    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2"
                   data-input-name="Bank Name">{{__('Bank Name')}}</label>
            <!--end::Label-->
            <!--begin::Input-->

            <input disabled type="text" name="bank_name"
                   class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder="" value="{{ isset($employee) ? $employee->bank_name : '' }}"/>
            <!--end::Input-->
        </div>
    </div>

    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('Bank branch #')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input disabled type="text" name="bank_branch"
                   class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder="" value="{{ isset($employee) ? $employee->bank_branch : '' }}"/>
            <!--end::Input-->
        </div>
    </div>


    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('BANK_IBAN')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input disabled type="text" name="bank_iban" class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder="" value="{{ isset($employee) ? $employee->bank_iban : '' }}"/>
            <!--end::Input-->
        </div>
    </div>
    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('BANK_Account')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input disabled type="text" name="bank_account" class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder="" value="{{ isset($employee) ? $employee->bank_account : '' }}"/>
            <!--end::Input-->
        </div>
    </div>

    {{--    <div class="col-md-3">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fw-semibold fs-6 mb-2" data-input-name="Payment Type">
                    {{__('Payment Type')}}
                </label>
                <!--end::Label-->
                <!--begin::Input-->

                <select disabled class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                        name="payment_type"
                        data-placeholder="Select an option">
                    <option></option>
                    @foreach ($PAYMENT_TYPES as $p)
                        <option value="{{ $p->id }}"
                        @isset($employee)
                            @selected($employee->payment_type == $p->id)
                            @endisset>
                            {{ $p->name }}</option>
                    @endforeach
                </select>
                <!--end::Input-->
            </div>
        </div>

        <div class="col-md-3">
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fw-semibold fs-6 mb-2" data-input-name="Payment Due">
                    {{__('Payment Due')}}
                </label>
                <!--end::Label-->
                <!--begin::Input-->

                <select disabled class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                        name="payment_method"
                        data-placeholder="Select an option">
                    <option></option>
                    @foreach ($PAYMENT_METHODS as $p)
                        <option value="{{ $p->id }}"
                        @isset($employee)
                            @selected($employee->payment_method == $p->id)
                            @endisset>
                            {{ $p->name }}</option>
                    @endforeach
                </select>
                <!--end::Input-->
            </div>
        </div>--}}


</div>













