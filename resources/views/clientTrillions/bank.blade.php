<div class="row">
    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2"
                   data-input-name="Bank Name">{{__('Bank Name')}}</label>
            <!--end::Label-->
            <!--begin::Input-->

            <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                    name="bank_name"
                    data-placeholder="Select an option">
                <option></option>
                @foreach ($BANKS as $BANK)
                    <option value="{{ $BANK->id }}"
                    @isset($clientTrillion)

                        @selected($clientTrillion->bank_name == $BANK->id)

                        @endisset
                    @isset($facility)
                        @selected($facility->bank_name == $BANK->id)
                        @endisset>
                        {{ $BANK->name }}</option>
                @endforeach
            </select>
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
            <input type="text" name="bank_branch"
                   class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder=""
                   value="{{ isset($clientTrillion) ? $clientTrillion->bank_branch : (isset($facility)?$facility->bank_branch:null) }}"/>
            <!--end::Input-->
        </div>
    </div>


    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('IBAN')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="iban" class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder=""
                   value="{{ isset($clientTrillion) ? $clientTrillion->iban :  (isset($facility)?$facility->iban:null) }}"/>
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

                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                        name="payment_type"
                        data-placeholder="Select an option">
                    <option></option>
                    @foreach ($PAYMENT_TYPES as $p)
                        <option value="{{ $p->id }}"
                        @isset($clientTrillion)
                            @selected($clientTrillion->payment_type == $p->id)
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

                <select class="form-select form-select-solid mb-3 mb-lg-0" data-control="select2"
                        name="payment_method"
                        data-placeholder="Select an option">
                    <option></option>
                    @foreach ($PAYMENT_METHODS as $p)
                        <option value="{{ $p->id }}"
                        @isset($clientTrillion)
                            @selected($clientTrillion->payment_method == $p->id)
                            @endisset>
                            {{ $p->name }}</option>
                    @endforeach
                </select>
                <!--end::Input-->
            </div>
        </div>--}}

    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="benficiary">{{__('Benficiary')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="benficiary" class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder=""
                   value="{{ isset($clientTrillion) ? $clientTrillion->benficiary :  (isset($facility)?$facility->benficiary:'NA') }}"/>
            <!--end::Input-->
        </div>
    </div>


</div>
