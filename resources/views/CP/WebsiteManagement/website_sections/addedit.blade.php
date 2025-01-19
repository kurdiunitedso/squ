@php
    $name = isset($_model) ? $_model->getTranslations()['name'] : null;
    $description = isset($_model) ? $_model->getTranslations()['description'] : null;
@endphp

<div class="modal-content">
    {{-- Modal Header --}}
    <div class="modal-header">
        <h2 class="fw-bold">{{ t('Add ' . $_model::ui['p_ucf']) }}</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
            <span class="svg-icon svg-icon-1">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                </svg>
            </span>
        </div>
    </div>

    {{-- Modal Body --}}
    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <form id="{{ $_model::ui['s_lcf'] }}_modal_form" class="form"
            data-editMode="{{ isset($_model) ? 'enabled' : 'disabled' }}"
            action="{{ route($_model::ui['route'] . '.addedit') }}">
            @csrf
            @if (isset($_model))
                <input type="hidden" name="{{ $_model::ui['_id'] }}" value="{{ $_model->id }}">
            @endif

            {{-- Form Content --}}
            <div class="row">
                <div class="fv-row">

                    {{-- Active Status --}}
                    @foreach ([['name' => 'active', 'label' => 'Active']] as $checkbox)
                        <div class="align-items-center d-flex flex-row me-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="{{ $checkbox['name'] }}" name="{{ $checkbox['name'] }}"
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
                {{-- Name Fields --}}
                @foreach (config('app.locales') as $locale)
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">
                                {{ t('Name') }}
                                <small>({{ strtoupper($locale) }})</small>
                            </label>
                            <input type="text" name="name[{{ $locale }}]"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required"
                                placeholder="{{ t('Enter name in ' . strtoupper($locale)) }}"
                                value="{{ old("name[$locale]", isset($name) && is_array($name) && array_key_exists($locale, $name) ? $name[$locale] : '') }}" />
                        </div>
                    </div>
                @endforeach

                {{-- Description Fields --}}
                @foreach (config('app.locales') as $locale)
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">
                                {{ t('Description') }}
                                <small>({{ strtoupper($locale) }})</small>
                            </label>
                            <textarea name="description[{{ $locale }}]" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="{{ t('Enter description in ' . strtoupper($locale)) }}" rows="3">{{ old("description[$locale]", isset($description) && is_array($description) && array_key_exists($locale, $description) ? $description[$locale] : '') }}</textarea>
                        </div>
                    </div>
                @endforeach

                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Type') }}</label>
                        <select name="type_id"
                            class="form-select form-select-solid validate-required @error('type_id') is-invalid @enderror"
                            data-dropdown-parent="#kt_modal_general" data-allow-clear="true">
                            <option value="">{{ t('Select Type') }}</option>
                            @foreach ($website_section_type_list ?? [] as $type)
                                <option value="{{ $type->id }}"
                                    {{ $_model->type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Order') }}</label>
                        <input type="number" name="order"
                            class="form-control form-control-solid mb-3 mb-lg-0
                            {{-- validate-required --}}
                            validate-min-0 @error('order') is-invalid @enderror"
                            placeholder="{{ t('Enter Order') }}" value="{{ old('order', $_model->order ?? '') }}" />
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('URL') }}</label>
                        <input name="url"
                            class="form-control form-control-solid mb-3 mb-lg-0
                            @error('url') is-invalid @enderror"
                            placeholder="{{ t('Enter url') }}" value="{{ old('url', $_model->url ?? '') }}" />
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="fv-row">
                    <label class=" @if (!$_model->exists) required @endif fw-semibold fs-6 mb-2"
                        for="formFile">{{ __('Attachment') }}</label>
                    <input
                        class="form-control
                         {{-- @if (!$_model->exists) validate-required @endif --}}
                    @error('attachment_file') is-invalid @enderror"
                        type="file" id="formFile" name="attachment_file">
                    @if ($_model->exists)
                        <a href="{{ asset($_model->image) }}" target="_blank">Show file</a>
                    @endif
                    @error('attachment_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>



            </div>

            {{-- Form Actions --}}
            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3"
                    data-kt-modal-action="cancel{{ $_model::ui['s_ucf'] }}" data-bs-dismiss="modal">
                    {{ __('Discard') }}
                </button>
                <button type="submit" class="btn btn-primary"
                    data-kt-modal-action="submit{{ $_model::ui['s_lcf'] }}">
                    <span class="indicator-label">{{ __('Submit') }}</span>
                    <span class="indicator-progress">
                        {{ __('Please wait...') }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
