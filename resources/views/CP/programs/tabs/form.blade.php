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
