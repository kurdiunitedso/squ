<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ t($_model::ui['s_ucf'] . ' Details') }}</h3>
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
                            <input type="text" name="name[{{ $locale }}]"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required
                               @error("name.$locale") is-invalid @enderror"
                                placeholder="{{ t('Enter name in ' . strtoupper($locale)) }}"
                                value="{{ old("name.$locale", isset($_model) ? $_model->getTranslation('name', $locale) : '') }}" />
                            @error("name.$locale")
                                <div class="invalid-feedback">{{ $message }}</div>
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
                            placeholder="{{ t('Enter email') }}"
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
                            placeholder="{{ t('Enter phone') }}"
                            value="{{ old('phone', isset($_model) ? $_model->phone : '') }}" />
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Lead Source Type Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Source') }}</label>
                        <select name="source_id" disabled
                            class="form-select form-select-solid @error('source_id') is-invalid @enderror">
                            <option value="">{{ t('Select Source') }}</option>
                            @foreach ($lead_source_list ?? [] as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('source_id', isset($_model) ? $_model->source_id : '') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('source_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Lead Form Type Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Lead Form Type') }}</label>
                        <select name="form_type_id" disabled
                            class="form-select form-select-solid @error('lead_form_type_id') is-invalid @enderror">
                            <option value="">{{ t('Select Lead Form Type') }}</option>
                            @foreach ($lead_form_type_list ?? [] as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('lead_form_type_id', isset($_model) ? $_model->lead_form_type_id : '') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('lead_form_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Number of Family Members Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Number of Family Members') }}</label>
                        <input type="number" name="number_family_members"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-1 @error('number_family_members') is-invalid @enderror"
                            placeholder="{{ t('Enter number of family members') }}" min="1"
                            value="{{ old('number_family_members', isset($_model) ? $_model->number_family_members : '') }}" />
                        @error('number_family_members')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    {{-- Building Field --}}
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Building') }}</label>
                            <select name="building_id"
                                class="form-select form-select-solid validate-required @error('building_id') is-invalid @enderror">
                                <option value="">{{ t('Select Building') }}</option>
                                @foreach ($building_list ?? [] as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('building_id', isset($_model) ? $_model->building_id : '') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('building_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Desired Apartment Size Field --}}
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Desired Apartment Size') }}</label>
                            <select name="desired_apartment_size_id"
                                class="form-select form-select-solid validate-required @error('desired_apartment_size_id') is-invalid @enderror">
                                <option value="">{{ t('Select Desired Apartment Size') }}</option>
                                @foreach ($apartment_size_list ?? [] as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('desired_apartment_size_id', isset($_model) ? $_model->desired_apartment_size_id : '') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('desired_apartment_size_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Apartment Field --}}
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Apartment') }}</label>
                            <select name="apartment_id"
                                class="form-select form-select-solid validate-required @error('apartment_id') is-invalid @enderror">
                                <option value="">{{ t('Select Apartment') }}</option>
                            </select>
                            @error('apartment_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Status Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Status') }}</label>
                        <select name="status_id"
                            class="form-select form-select-solid validate-required @error('status_id') is-invalid @enderror">
                            <option value="">{{ t('Select Status') }}</option>
                            @foreach ($lead_status_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('status_id', isset($_model) ? $_model->status_id : '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Subject Field --}}
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Subject') }}</label>
                        <input type="text" name="subject"
                            class="form-control form-control-solid mb-3 mb-lg-0 @error('subject') is-invalid @enderror"
                            placeholder="{{ t('Enter subject') }}"
                            value="{{ old('subject', isset($_model) ? $_model->subject : '') }}" />
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Notes Field --}}
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Notes') }}</label>
                        <textarea name="notes" class="form-control form-control-solid mb-3 mb-lg-0 @error('notes') is-invalid @enderror"
                            rows="4" placeholder="{{ t('Enter notes') }}">{{ old('notes', isset($_model) ? $_model->notes : '') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>
