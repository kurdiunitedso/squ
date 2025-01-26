{{-- resources/views/CP/program-questions/addedit.blade.php --}}
<div class="modal-content">
    <form id="{{ isset($_model) ? 'update' : 'store' }}_{{ $_model['s_lcf'] }}_form" class="form" {{-- action="{{ route($_model['route'] . '.addedit', ['program' => $program->id, 'page' => $page->id]) }}" --}}
        method="POST">
        @csrf
        @if (isset($_model))
            <input type="hidden" name="{{ $_model['_id'] }}" value="{{ $_model->id }}">
        @endif

        <div class="modal-header">
            <h2 class="fw-bold">{{ isset($_model) ? t('Edit ' . $_model['s_ucf']) : t('Add New ' . $_model['s_ucf']) }}
            </h2>
            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-modal-action="close">
                {!! getSvgIcon('cross') !!}
            </div>
        </div>

        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
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

                {{-- Type --}}
                <div class="col-md-6">
                    <label class="required fw-semibold fs-6 mb-2">{{ t('Type') }}</label>
                    <select name="type" class="form-select" id="question_type" required>
                        <option value="">{{ t('Select Type') }}</option>
                        @foreach ($question_type_list ?? [] as $type)
                            <option value="{{ $type->constant_name }}"
                                {{ isset($_model) && $_model->type == $type->constant_name ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Score --}}
                <div class="col-md-6">
                    <label class="fw-semibold fs-6 mb-2">{{ t('Score') }}</label>
                    <input type="number" name="score" class="form-control"
                        value="{{ isset($_model) ? $_model->score : 0 }}" min="0">
                </div>

                {{-- Options --}}
                <div class="col-12 options-section" style="display: none;">
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
                </div>

                {{-- Required --}}
                <div class="col-md-6">
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" name="required" value="1"
                            {{ isset($_model) && $_model->required ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold fs-6">
                            {{ t('Required') }}
                        </label>
                    </div>
                </div>

                {{-- Order --}}
                <div class="col-md-6">
                    <label class="required fw-semibold fs-6 mb-2">{{ t('Order') }}</label>
                    <input type="number" name="order" class="form-control"
                        value="{{ isset($_model) ? $_model->order : $max_order ?? 0 }}" min="0" required>
                </div>
            </div>
        </div>
        <div class="text-center pt-15">
            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">
                {{ t('Discard') }}
            </button>
            <button type="submit" class="btn btn-primary" data-kt-modal-action="submit_{{ $_model::ui['s_lcf'] }}">
                <span class="indicator-label">{{ t('Submit') }}</span>
                <span class="indicator-progress">{{ t('Please wait...') }}
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    </form>
</div>
