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
                    @isset($insuranceCompany)
                        @selected($insuranceCompany->bank_name == $BANK->id)
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
            <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('Bank branch')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="bank_branch"
                   class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder="" value="{{ isset($insuranceCompany) ? $insuranceCompany->bank_branch : '' }}"/>
            <!--end::Input-->
        </div>
    </div>

    <div class="col-md-3">
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2" data-input-name="">{{__('Bank branch no')}}
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="bank_branch_no"
                   class="form-control form-control-solid mb-3 mb-lg-0"
                   placeholder="" value="{{ isset($insuranceCompany) ? $insuranceCompany->bank_branch_no : '' }}"/>
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
                   placeholder="" value="{{ isset($insuranceCompany) ? $insuranceCompany->iban : '' }}"/>
            <!--end::Input-->
        </div>
    </div>


</div>
