@php
    use App\Models\Client;
@endphp
<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title m-0 w-600px">
            <select class="form-select form-select-solid mb-3 mb-lg-0 " id="{{ Client::ui['_id'] }}" data-control="select2"
                name="{{ Client::ui['_id'] }}" data-placeholder="{{ t('Select ' . Client::ui['s_ucf']) }}"
                data-allow-clear="true">
                <option></option>
            </select>
        </div>
        <!--end::Card title-->
    </div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body p-9">
            <div class="row">
                {{-- Translatable Name Fields --}}
                @foreach (config('app.locales') as $locale)
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">
                                {{ t('Name') }}
                                <small>({{ strtoupper($locale) }})</small>
                            </label>
                            <input type="text" name="client_name[{{ $locale }}]"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required
                                  @error("client_name.$locale") is-invalid @enderror"
                                placeholder="{{ t('Enter name in ' . strtoupper($locale)) }}"
                                value="{{ old("client_name.$locale", isset($_model) ? $_model->getTranslation('name', $locale) : '') }}" />
                            @error("client_name.$locale")
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                @endforeach

                {{-- Email Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Email') }}</label>
                        <input type="email" name="client_email"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-email @error('client_email') is-invalid @enderror"
                            placeholder="{{ t('Enter Email Address') }}"
                            value="{{ old('client_email', isset($_model) ? $_model->email : '') }}" />
                        @error('client_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Phone Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Phone') }}</label>
                        <input type="text" name="client_phone"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required @error('client_phone') is-invalid @enderror"
                            placeholder="{{ t('Enter Phone Number') }}"
                            value="{{ old('client_phone', isset($_model) ? $_model->phone : '') }}" />
                        @error('client_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Address Field --}}
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Address') }}</label>
                        <input type="text" name="client_address"
                            class="form-control form-control-solid mb-3 mb-lg-0 @error('client_address') is-invalid @enderror"
                            placeholder="{{ t('Enter Address') }}"
                            value="{{ old('client_address', isset($_model) ? $_model->address : '') }}" />
                        @error('client_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Number of Family Members Field --}}
                <div class="col-md-3">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Number of Family Members') }}</label>
                        <input type="number" name="client_number_family_members"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('client_number_family_members') is-invalid @enderror"
                            placeholder="{{ t('Enter Number of Family Members') }}"
                            value="{{ old('client_number_family_members', isset($_model) ? $_model->number_family_members : '') }}" />
                        @error('client_number_family_members')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    {{-- Bank Field --}}
                    <div class="col-md-3">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Bank') }}</label>
                            <select name="client_bank_id"
                                class="form-select form-select-solid @error('client_bank_id') is-invalid @enderror">
                                <option value="">{{ t('Select Bank') }}</option>
                                @foreach ($bank_list ?? [] as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('client_bank_id', isset($_model) ? $_model->bank_id : '') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_bank_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Bank Branch Field --}}
                    <div class="col-md-3">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Bank Branch') }}</label>
                            <select name="client_bank_branch_id"
                                class="form-select form-select-solid validate-required @error('client_bank_branch_id') is-invalid @enderror">
                                <option value="">{{ t('Select Bank Branch') }}</option>
                            </select>
                            @error('client_bank_branch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Bank IBAN Field --}}
                    <div class="col-md-3">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Bank IBAN') }}</label>
                            <input name="client_bank_iban"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('client_bank_iban') is-invalid @enderror"
                                placeholder="{{ t('Enter Bank IBAN') }}"
                                value="{{ old('client_bank_iban', isset($_model) ? $_model->bank_iban : '') }}" />
                            @error('client_bank_iban')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Bank Account Number Field --}}
                    <div class="col-md-3">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Bank Account Number') }}</label>
                            <input name="client_bank_account_number"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('client_bank_account_number') is-invalid @enderror"
                                placeholder="{{ t('Enter Bank Account Number') }}"
                                value="{{ old('client_bank_account_number', isset($_model) ? $_model->bank_account_number : '') }}" />
                            @error('client_bank_account_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
