<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ t($_model::ui['s_ucf'] . ' Details') }}</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->
    <!--begin::Card body-->
    <div class="card mb-5 mb-xl-10">

        <!--begin::Card body-->
        <div class="card-body p-9">
            <div class="row">
                {{-- Translatable Name Fields --}}
                @php
                    $name = isset($_model) ? $_model->getTranslations()['name'] ?? [] : [];
                @endphp
                @foreach (config('app.locales') as $locale)
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2" data-input-name="name_{{ $locale }}">
                                {{ t('Name') }}
                                <small>({{ strtoupper($locale) }})</small>
                            </label>
                            <input type="text" name="name[{{ $locale }}]"
                                class="form-control form-control-solid mb-3 mb-lg-0
                                validate-required
                                @error("name.$locale") is-invalid @enderror"
                                placeholder="{{ t('Enter name in ' . strtoupper($locale)) }}"
                                value="{{ old("name.$locale", isset($name[$locale]) ? $name[$locale] : '') }}" />
                            @error("name.$locale")
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                @endforeach

                {{-- Code Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Code') }}</label>
                        <input type="text" name="code"
                            class="form-control form-control-solid mb-3 mb-lg-0
                            validate-required
                            @error('code') is-invalid @enderror"
                            placeholder="{{ t('Enter code') }}" value="{{ old('code', $_model->code ?? '') }}" />
                        @error('code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">

                    {{-- Floors Number Field --}}
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Number of Floors') }}</label>
                            <input type="number" name="floors_number"
                                class="form-control form-control-solid mb-3 mb-lg-0
                            validate-required
                            validate-number
                            validate-min-1
                            @error('floors_number') is-invalid @enderror"
                                placeholder="{{ t('Enter number of floors') }}" min="1"
                                value="{{ old('floors_number', $_model->floors_number ?? '') }}" />
                            @error('floors_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Apartments Number Field --}}
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Number of Apartments') }}</label>
                            <input type="number" name="apartments_number"
                                class="form-control form-control-solid mb-3 mb-lg-0
                              validate-required
                            validate-number
                            validate-min-1
                             @error('apartments_number') is-invalid @enderror"
                                placeholder="{{ t('Enter number of apartments') }}" min="1"
                                value="{{ old('apartments_number', $_model->apartments_number ?? '') }}" />
                            @error('apartments_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- City Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('City') }}</label>
                        <select name="city_id"
                            class="form-select form-select-solid
                        validate-required
                        @error('city_id') is-invalid @enderror">
                            <option value="">{{ t('Select City') }}</option>
                            @foreach ($city_list ?? [] as $city)
                                <option value="{{ $city->id }}"
                                    {{ old('city_id', $_model->city_id ?? '') == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Address Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Address') }}</label>
                        <input type="text" name="address"
                            class="form-control form-control-solid mb-3 mb-lg-0
                            validate-required
                            @error('address') is-invalid @enderror"
                            placeholder="{{ t('Enter address') }}"
                            value="{{ old('address', $_model->address ?? '') }}" />
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>


                {{-- Description Field --}}
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Description') }}</label>
                        <textarea name="description"
                            class="form-control form-control-solid mb-3 mb-lg-0 @error('description') is-invalid @enderror" rows="4"
                            placeholder="{{ t('Enter description') }}">{{ old('description', $_model->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>


        </div>

    </div>

    <!--end::Card body-->
</div>
