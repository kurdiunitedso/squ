@php
    use App\Models\ProgramPage;
@endphp
<div class="modal-content">
    <div class="modal-header">
        <h2 class="fw-bold">{{ t('Form Generator') }} - {{ $_model->title }}</h2>
        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
            <span class="svg-icon svg-icon-1">
                {!! getSvgIcon('delete') !!}
            </span>
        </div>
    </div>

    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
        <form id="form_generator_modal_form" class="form"
            action="{{ route('programs.program-pages.update-structure', ['program' => $program->id, '_model' => $_model->id]) }}">
            <div class="form-builder-container">
                <!-- Form builder will be initialized here -->
            </div>

            <div class="text-center pt-15">
                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">
                    {{ t('Discard') }}
                </button>
                <button type="submit" class="btn btn-primary" data-kt-modal-action="submit_form_generator">
                    <span class="indicator-label">{{ t('Save Structure') }}</span>
                    <span class="indicator-progress">{{ t('Please wait...') }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
