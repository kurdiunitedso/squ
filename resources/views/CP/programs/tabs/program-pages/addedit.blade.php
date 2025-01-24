@php
    use App\Models\ProgramPage;
@endphp
<div class="modal-content">
    <div class="modal-header">
        <h2 class="fw-bold">{{ isset($_model) ? t('Edit Program Page') : t('Add Program Page') }}</h2>
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
        <form id="{{ ProgramPage::ui['s_lcf'] }}_modal_form" class="form"
            action="{{ route('programs.program-pages.addedit', ['program' => $program->id]) }}">
            @if (isset($_model))
                <input type="hidden" name="program_page_id" value="{{ $_model->id }}">
            @endif

            <div class="d-flex flex-column scroll-y me-n7 pe-7">
                <div class="row">
                    {{-- Translatable Title Fields --}}
                    @foreach (config('app.locales') as $locale)
                        <div class="col-md-6">
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">
                                    {{ t('Title') }}
                                    <small>({{ strtoupper($locale) }})</small>
                                </label>
                                <input type="text" name="title[{{ $locale }}]"
                                    class="form-control form-control-solid mb-3 mb-lg-0 validate-required
                                    @error("title.$locale") is-invalid @enderror"
                                    placeholder="{{ t('Enter title in ' . strtoupper($locale)) }}"
                                    value="{{ old("title.$locale", isset($_model) ? $_model->getTranslation('title', $locale) : '') }}" />
                                @error("title.$locale")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                    {{-- Order Field --}}
                    <div class="col-md-6">
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">{{ t('Order') }}</label>
                            <input type="number" name="order"
                                class="form-control form-control-solid mb-3 mb-lg-0 validate-required validate-number"
                                value="{{ old('order', isset($_model) ? $_model->order : 0) }}" min="0" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center pt-15">
                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">
                    {{ t('Discard') }}
                </button>
                <button type="submit" class="btn btn-primary"
                    data-kt-modal-action="submit_{{ ProgramPage::ui['s_lcf'] }}">
                    <span class="indicator-label">{{ t('Submit') }}</span>
                    <span class="indicator-progress">{{ t('Please wait...') }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
