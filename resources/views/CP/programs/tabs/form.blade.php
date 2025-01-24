@php
    use App\Models\PriceOffer;
@endphp
<div class="card mb-5 mb-xl-10">
    <div class="card-header">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ t($_model::ui['s_ucf'] . ' Details') }}</h3>
        </div>

    </div>

    <div class="card mb-5 mb-xl-10">
        <div class="card-body p-9">
            <div class="row">
                {{-- Translatable Name Fields --}}
                @foreach (config('app.locales') as $locale)
                    <div class="col-md-3">
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
                <div class="col-md-3">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Deadline') }}</label>
                        <input type="text" name="deadline"
                            class="form-control form-control-solid date-picker-future validate-required"
                            value="{{ old('deadline', isset($_model->deadline) ? $_model->deadline->format('Y-m-d') : '') }}" />
                        {{-- value="{{ old('deadline', isset($_model) ? $_model->deadline->format('Y-m-d') : '') }}" /> --}}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Target Applicants') }}</label>
                        <select name="target_applicant_id" class="form-select form-select-solid validate-required">
                            <option value="">{{ t('Select Target') }}</option>
                            @foreach ($program_target_applicants_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('target_applicant_id', $_model->target_applicant_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Category') }}</label>
                        <select name="category_id" class="form-select form-select-solid validate-required">
                            <option value="">{{ t('Select Category') }}</option>
                            @foreach ($program_category_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('category_id', $_model->category_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Eligibility') }}</label>
                        <select name="eligibility_ids[]" class="form-select form-select-solid validate-required"
                            multiple>
                            @foreach ($program_eligibility_type_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ in_array($item->id, old('eligibility_ids', $_model->eligibilities->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Fund Amount -->
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Fund Amount') }}</label>
                        <input type="number" name="fund" step="0.01"
                            class="form-control form-control-solid mb-3 mb-lg-0"
                            value="{{ old('fund', $_model->fund ?? '') }}" />
                    </div>
                </div>

                <!-- Facilities -->
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Facilities') }}</label>
                        <select name="facility_ids[]" class="form-select form-select-solid" multiple>
                            @foreach ($program_facility_list ?? [] as $item)
                                <option value="{{ $item->id }}"
                                    {{ in_array($item->id, old('facility_ids', $_model->facilities->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <!-- Important Dates Repeater -->
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Important Dates') }}</label>
                        <div id="important-dates-repeater">
                            <div data-repeater-list="important_dates">
                                @if (isset($_model) && $_model->importantDates->count())
                                    @foreach ($_model->importantDates as $date)
                                        <div data-repeater-item class="form-group d-flex flex-wrap mb-3">
                                            @foreach (config('app.locales') as $locale)
                                                <div class="col-md-4 pe-2 mb-2">
                                                    <input type="text" name="title[{{ $locale }}]"
                                                        class="form-control form-control-solid validate-required"
                                                        placeholder="{{ t('Title in ' . strtoupper($locale)) }}"
                                                        value="{{ $date->getTranslation('title', $locale) }}">
                                                </div>
                                            @endforeach
                                            <div class="col-md-3 pe-2">
                                                <input type="text" name="date"
                                                    class="form-control form-control-solid date-picker validate-required"
                                                    placeholder="{{ t('Select date') }}"
                                                    value="{{ $date->date->format('Y-m-d') }}">
                                            </div>
                                            <div class="col-auto">
                                                <button type="button" data-repeater-delete
                                                    class="btn btn-sm btn-light-danger">
                                                    <i class="la la-trash-o"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div data-repeater-item class="form-group d-flex flex-wrap mb-3">
                                        @foreach (config('app.locales') as $locale)
                                            <div class="col-md-4 pe-2 mb-2">
                                                <input type="text" name="title[{{ $locale }}]"
                                                    class="form-control form-control-solid validate-required"
                                                    placeholder="{{ t('Title in ' . strtoupper($locale)) }}">
                                            </div>
                                        @endforeach
                                        <div class="col-md-3 pe-2">
                                            <input type="text" name="date"
                                                class="form-control form-control-solid date-picker validate-required"
                                                placeholder="{{ t('Select date') }}">
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" data-repeater-delete
                                                class="btn btn-sm btn-light-danger">
                                                <i class="la la-trash-o"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" data-repeater-create class="btn btn-light-primary">
                                <i class="la la-plus"></i> {{ t('Add Date') }}
                            </button>
                        </div>
                    </div>
                </div>



                <div class="row">
                    @foreach (config('app.locales') as $locale)
                        <div class="col-md-6">
                            <div class="fv-row mb-7">
                                <label class="fw-semibold fs-6 mb-2">
                                    {{ t('Description') }}
                                    <small>({{ strtoupper($locale) }})</small>
                                </label>
                                <textarea name="description[{{ $locale }}]"
                                    class="form-control form-control-solid mb-3 mb-lg-0 validate-required" rows="4">{{ old("description.$locale", isset($_model) ? $_model->getTranslation('description', $locale) : '') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fv-row mb-7">
                                <label class="fw-semibold fs-6 mb-2">
                                    {{ t('How To Apply') }}
                                    <small>({{ strtoupper($locale) }})</small>
                                </label>
                                <textarea name="how_to_apply[{{ $locale }}]"
                                    class="form-control form-control-solid mb-3 mb-lg-0 validate-required" rows="4">{{ old("how_to_apply.$locale", isset($_model) ? $_model->getTranslation('how_to_apply', $locale) : '') }}</textarea>
                            </div>
                        </div>
                    @endforeach

                </div>

                {{-- Status Field --}}
                {{-- <div class="col-md-4">
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
                </div> --}}


            </div>

        </div>
    </div>


</div>
