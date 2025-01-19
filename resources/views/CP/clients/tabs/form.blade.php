<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ t($_model::ui['s_ucf'] . ' Details') }}</h3>
        </div>
        <!--end::Card title-->

        <!--end::Card title-->
        <div class="card-toolbar">
            @foreach ([['name' => 'active', 'label' => 'Active']] as $checkbox)
                <div class="align-items-center d-flex flex-row me-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="{{ $checkbox['name'] }}"
                            name="{{ $checkbox['name'] }}"
                            @isset($_model)
                                @checked($_model->{$checkbox['name']} == 1)
                            @endisset
                            @if (old($checkbox['name'])) checked @endif>
                        <label class="form-check-label cursor-pointer text-primary fw-semibold fs-6"
                            for="{{ $checkbox['name'] }}">
                            {{ t($checkbox['label']) }}</label>
                    </div>
                </div>
            @endforeach
        </div>
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
                            <input type="text" name="name[{{ $locale }}]"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required
                                  @error("name.$locale") is-invalid @enderror"
                                placeholder="{{ t('Enter name in ' . strtoupper($locale)) }}"
                                value="{{ old("name.$locale", isset($_model) ? $_model->getTranslation('name', $locale) : '') }}" />
                            @error("name.$locale")
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
                        <input type="email" name="email"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-email @error('email') is-invalid @enderror"
                            placeholder="{{ t('Enter Email Address') }}"
                            value="{{ old('email', isset($_model) ? $_model->email : '') }}" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Phone Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Phone') }}</label>
                        <input type="text" name="phone"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required @error('phone') is-invalid @enderror"
                            placeholder="{{ t('Enter Phone Number') }}"
                            value="{{ old('phone', isset($_model) ? $_model->phone : '') }}" />
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Address Field --}}
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Address') }}</label>
                        <input type="text" name="address"
                            class="form-control form-control-solid mb-3 mb-lg-0 @error('address') is-invalid @enderror"
                            placeholder="{{ t('Enter Address') }}"
                            value="{{ old('address', isset($_model) ? $_model->address : '') }}" />
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Number of Family Members Field --}}
                <div class="col-md-3">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Number of Family Members') }}</label>
                        <input type="number" name="number_family_members"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('number_family_members') is-invalid @enderror"
                            placeholder="{{ t('Enter Number of Family Members') }}"
                            value="{{ old('number_family_members', isset($_model) ? $_model->number_family_members : '') }}" />
                        @error('number_family_members')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    {{-- Bank Field --}}
                    <div class="col-md-3">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Bank') }}</label>
                            <select name="bank_id"
                                class="form-select form-select-solid @error('bank_id') is-invalid @enderror">
                                <option value="">{{ t('Select Bank') }}</option>
                                @foreach ($bank_list ?? [] as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('bank_id', isset($_model) ? $_model->bank_id : '') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bank_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Bank Branch Field --}}
                    <div class="col-md-3">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Bank Branch') }}</label>
                            <select name="bank_branch_id"
                                class="form-select form-select-solid validate-required @error('bank_branch_id') is-invalid @enderror">
                                <option value="">{{ t('Select Bank Branch') }}</option>
                            </select>
                            @error('bank_branch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Bank IBAN Field --}}
                    <div class="col-md-3">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Bank IBAN') }}</label>
                            <input name="bank_iban"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('bank_iban') is-invalid @enderror"
                                placeholder="{{ t('Enter Bank IBAN') }}"
                                value="{{ old('bank_iban', isset($_model) ? $_model->bank_iban : '') }}" />
                            @error('bank_iban')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Bank Account Number Field --}}
                    <div class="col-md-3">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Bank Account Number') }}</label>
                            <input name="bank_account_number"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-0 @error('bank_account_number') is-invalid @enderror"
                                placeholder="{{ t('Enter Bank Account Number') }}"
                                value="{{ old('bank_account_number', isset($_model) ? $_model->bank_account_number : '') }}" />
                            @error('bank_account_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
