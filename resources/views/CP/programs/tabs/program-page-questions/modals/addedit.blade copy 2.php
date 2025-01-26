@php
    use App\Models\Program;
    use App\Models\ProgramPage;
    use App\Models\ProgramPageQuestion;

    $route = Program::ui['route'] . '.' . ProgramPageQuestion::ui['route'] . '.addedit';
@endphp
<div class="modal-content">
    <div class="modal-header">
        <h2 class="fw-bold">{{ $_model->exists ? t('Edit ' . $_model::ui['s_ucf']) : t('Add ' . $_model::ui['s_ucf']) }}
        </h2>
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

    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <form id="{{ $_model::ui['s_lcf'] }}_modal_form" class="form"
            action="{{ route($route, ['program' => $program->id]) }}">
            @if (isset($_model))
                <input type="hidden" name="program_page_id" value="{{ $_model->id }}">
            @endif

            <div class="d-flex flex-column scroll-y me-n7 pe-7">
                <div class="row g-9 mb-8">
                    {{-- Translatable Question Fields --}}
                    @foreach (config('app.locales') as $locale)
                        <div class="col-6">
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">
                                    {{ t('Question') }}
                                    <small>({{ strtoupper($locale) }})</small>
                                </label>
                                <input type="text" name="question[{{ $locale }}]"
                                    class="form-control form-control-solid mb-3 mb-lg-0 validate-required
                                 @error("question.$locale") is-invalid @enderror"
                                    placeholder="{{ t('Enter question in ' . strtoupper($locale)) }}"
                                    value="{{ old("question.$locale", isset($_model) ? $_model->getTranslation('question', $locale) : '') }}" />
                                @error("question.$locale")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                    {{-- program_page_list --}}
                    <div class="col-md-4">
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">{{ t('Program Page') }}</label>
                            <select name="program_page_id"
                                class="form-select form-select-solid validate-required @error('program_page_id') is-invalid @enderror"
                                data-dropdown-parent="#kt_modal_general" data-allow-clear="true">
                                <option value="">{{ t('Select Type') }}</option>
                                @foreach ($program_page_list ?? [] as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $_model->program_page_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('program_page_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- Type --}}
                    {{-- <div class="col-md-6">
                        <label class="required fw-semibold fs-6 mb-2">{{ t('Type') }}</label>
                        <select name="type" class="form-select" id="question_type" required>
                            <option value="">{{ t('Select Type') }}</option>
                            @foreach ($question_type_list ?? [] as $item)
                                <option value="{{ $item->constant_name }}"
                                    {{ isset($_model) && $_model->type == $item->constant_name ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}

                    {{-- Score --}}
                    {{-- <div class="col-md-6">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Score') }}</label>
                        <input type="number" name="score" class="form-control"
                            value="{{ isset($_model) ? $_model->score : 0 }}" min="0">
                    </div> --}}

                    {{-- Options --}}
                    {{-- <div class="col-12 options-section" style="display: none;">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Options') }}</label>
                        <div class="options-container">
                            @if (isset($_model) && $_model->options)
                                @foreach ($_model->options as $key => $option)
                                    <div class="option-row mb-3">
                                        <div class="input-group">
                                            <input type="text" name="options[{{ $key }}][en]"
                                                class="form-control" placeholder="{{ t('Option in English') }}"
                                                value="{{ $option['en'] ?? '' }}">
                                            <input type="text" name="options[{{ $key }}][ar]"
                                                class="form-control" placeholder="{{ t('Option in Arabic') }}"
                                                value="{{ $option['ar'] ?? '' }}">
                                            <button type="button" class="btn btn-danger remove-option">
                                                {!! getSvgIcon('trash') !!}
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-light-primary add-option mt-3">
                            {!! getSvgIcon('plus') !!}
                            {{ t('Add Option') }}
                        </button>
                    </div> --}}

                    {{-- Required --}}
                    {{-- <div class="col-md-6">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="required" value="1"
                                {{ isset($_model) && $_model->required ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold fs-6">
                                {{ t('Required') }}
                            </label>
                        </div>
                    </div> --}}

                    {{-- Order --}}
                    {{-- <div class="col-md-6">
                        <label class="required fw-semibold fs-6 mb-2">{{ t('Order') }}</label>
                        <input type="number" name="order" class="form-control"
                            value="{{ isset($_model) ? $_model->order : $max_order ?? 0 }}" min="0" required>
                    </div> --}}
                </div>
            </div>

            <div class="text-center pt-15">
                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">
                    {{ t('Discard') }}
                </button>
                <button type="submit" class="btn btn-primary"
                    data-kt-modal-action="submit_{{ $_model::ui['s_lcf'] }}">
                    <span class="indicator-label">{{ t('Submit') }}</span>
                    <span class="indicator-progress">{{ t('Please wait...') }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
