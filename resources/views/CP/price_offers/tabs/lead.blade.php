@php
    use App\Models\Lead;
    $lead_prifx = Lead::ui['s_lcf'];
@endphp

<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title m-0 w-600px">
            <select class="form-select form-select-solid mb-3 mb-lg-0 " id="{{ Lead::ui['_id'] }}" data-control="select2"
                name="{{ Lead::ui['_id'] }}" data-placeholder="{{ t('Select Lead') }}" data-allow-clear="true">
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
                            <input type="text" name="{{ Lead::ui['s_lcf'] }}_name[{{ $locale }}]"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required
                   @error(Lead::ui['s_lcf'] . '_name.' . $locale) is-invalid @enderror"
                                placeholder="{{ t('Enter name in ' . strtoupper($locale)) }}"
                                value="{{ old(Lead::ui['s_lcf'] . '_name.' . $locale) }}" />
                            @error(Lead::ui['s_lcf'] . '_name.' . $locale)
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
                        <input type="email" name="{{ Lead::ui['s_lcf'] }}_email"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-email @error(Lead::ui['s_lcf'] . '_email') is-invalid @enderror"
                            placeholder="{{ t('Enter email') }}" value="{{ old(Lead::ui['s_lcf'] . '_email') }}" />
                        @error(Lead::ui['s_lcf'] . '_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Phone Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Phone') }}</label>
                        <input type="text" name="{{ Lead::ui['s_lcf'] }}_phone"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required @error(Lead::ui['s_lcf'] . '_phone') is-invalid @enderror"
                            placeholder="{{ t('Enter phone') }}" value="{{ old(Lead::ui['s_lcf'] . '_phone') }}" />
                        @error(Lead::ui['s_lcf'] . '_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Lead Source Type Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Source') }}</label>
                        <select name="{{ Lead::ui['s_lcf'] }}_source_id" disabled
                            class="form-select form-select-solid @error(Lead::ui['s_lcf'] . '_source_id') is-invalid @enderror">
                            <option value="">{{ t('Select Source') }}</option>
                            @foreach ($lead_source_list ?? [] as $type)
                                <option value="{{ $type->id }}"
                                    {{ old(Lead::ui['s_lcf'] . '_source_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error(Lead::ui['s_lcf'] . '_source_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Lead Form Type Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Lead Form Type') }}</label>
                        <select name="{{ Lead::ui['s_lcf'] }}_lead_form_type_id" disabled
                            class="form-select form-select-solid @error(Lead::ui['s_lcf'] . '_lead_form_type_id') is-invalid @enderror">
                            <option value="">{{ t('Select Lead Form Type') }}</option>
                            @foreach ($lead_form_type_list ?? [] as $type)
                                <option value="{{ $type->id }}"
                                    {{ old(Lead::ui['s_lcf'] . '_lead_form_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error(Lead::ui['s_lcf'] . '_lead_form_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Number of Family Members Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Number of Family Members') }}</label>
                        <input type="number" name="{{ Lead::ui['s_lcf'] }}_number_family_members"
                            class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number validate-min-1 @error(Lead::ui['s_lcf'] . '_number_family_members') is-invalid @enderror"
                            placeholder="{{ t('Enter number of family members') }}" min="1"
                            value="{{ old(Lead::ui['s_lcf'] . '_number_family_members') }}" />
                        @error(Lead::ui['s_lcf'] . '_number_family_members')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    {{-- Building Field --}}
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Building') }}</label>
                            <select name="{{ Lead::ui['s_lcf'] }}_building_id"
                                class="form-select form-select-solid validate-required @error(Lead::ui['s_lcf'] . '_building_id') is-invalid @enderror">
                                <option value="">{{ t('Select Building') }}</option>
                                @foreach ($building_list ?? [] as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old(Lead::ui['s_lcf'] . '_building_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error(Lead::ui['s_lcf'] . '_building_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Desired Apartment Size Field --}}
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Desired Apartment Size') }}</label>
                            <select name="{{ Lead::ui['s_lcf'] }}_desired_apartment_size_id"
                                class="form-select form-select-solid validate-required @error(Lead::ui['s_lcf'] . '_desired_apartment_size_id') is-invalid @enderror">
                                <option value="">{{ t('Select Desired Apartment Size') }}</option>
                                @foreach ($apartment_size_list ?? [] as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old(Lead::ui['s_lcf'] . '_desired_apartment_size_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error(Lead::ui['s_lcf'] . '_desired_apartment_size_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Apartment Field --}}
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Apartment') }}</label>
                            <select name="{{ Lead::ui['s_lcf'] }}_apartment_id"
                                class="form-select form-select-solid validate-required @error(Lead::ui['s_lcf'] . '_apartment_id') is-invalid @enderror">
                                <option value="">{{ t('Select Apartment') }}</option>
                                {{-- @foreach ($apartment_list ?? [] as $apartment)
                        <option value="{{ $apartment->id }}"
                            {{ old(Lead::ui['s_lcf'] . '_apartment_id') == $apartment->id ? 'selected' : '' }}>
                            {{ $apartment->name }}
                        </option>
                    @endforeach --}}
                            </select>
                            @error(Lead::ui['s_lcf'] . '_apartment_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Status Field --}}
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Status') }}</label>
                        <select name="{{ Lead::ui['s_lcf'] }}_status_id"
                            class="form-select form-select-solid validate-required @error(Lead::ui['s_lcf'] . '_status_id') is-invalid @enderror">
                            <option value="">{{ t('Select Status') }}</option>
                            @foreach ($lead_status_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ old(Lead::ui['s_lcf'] . '_status_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error(Lead::ui['s_lcf'] . '_status_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Subject Field --}}
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Subject') }}</label>
                        <input type="text" name="{{ Lead::ui['s_lcf'] }}_subject"
                            class="form-control form-control-solid mb-3 mb-lg-0  @error(Lead::ui['s_lcf'] . '_subject') is-invalid @enderror"
                            placeholder="{{ t('Enter subject') }}"
                            value="{{ old(Lead::ui['s_lcf'] . '_subject') }}" />
                        @error(Lead::ui['s_lcf'] . '_subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Notes Field --}}
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Notes') }}</label>
                        <textarea name="{{ Lead::ui['s_lcf'] }}_notes"
                            class="form-control form-control-solid mb-3 mb-lg-0 @error(Lead::ui['s_lcf'] . '_notes') is-invalid @enderror"
                            rows="4" placeholder="{{ t('Enter notes') }}">{{ old(Lead::ui['s_lcf'] . '_notes') }}</textarea>
                        @error(Lead::ui['s_lcf'] . '_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>
