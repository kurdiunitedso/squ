@php
    use App\Models\ProgramPage;
    use App\Models\ProgramPageQuestion;

@endphp
@extends('CP.metronic.index')


@section('subpageTitle', $_model::ui['p_ucf'])
@section('subpageTitleLink', route($_model::ui['route'] . '.index'))

@section('title', t($_model::ui['s_ucf'] . ($_model->exists ? ' Edit ' : '- Add new ') . $_model::ui['s_ucf']))
@section('subpageTitle', $_model::ui['s_ucf'])
@section('subpageName', ($_model->exists ? ' Edit ' : '- Add new ') . $_model::ui['s_ucf'])
@push('styles')
    <link href="{{ asset('css/custom.css?v=1') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    @include('CP.partials.notification')

    <!--begin::Pages Section-->
    <div class="d-flex flex-column gap-5">
        <!--begin::Add Page Button-->
        <div class="text-end">
            <button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_page">
                <i class="ki-duotone ki-plus fs-2"></i>
                Add New Page
            </button>
        </div>
        <!--end::Add Page Button-->

        <!--begin::Pages Grid-->
        <div class="row g-6">
            @foreach ($_model->pages as $page)
                <!--begin::Page Card-->
                <div class="col-xl-4 col-lg-6">
                    <div class="card h-100">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6">
                            <div class="card-title">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-50px me-3">
                                        <div class="symbol-label fs-2 fw-semibold bg-light-primary text-primary">
                                            {{ $loop->iteration }}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h3 class="fs-3 mb-1">{{ $page->title }}</h3>
                                        <span class="text-muted fs-7">{{ $page->questions->count() }} Questions</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-icon btn-light-primary me-2"
                                    data-bs-toggle="modal" data-bs-target="#kt_modal_edit_page_{{ $page->id }}">
                                    <i class="ki-duotone ki-pencil fs-2"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-icon btn-light-danger"
                                    data-action="delete-page" data-page-id="{{ $page->id }}">
                                    <i class="ki-duotone ki-trash fs-2"></i>
                                </button>
                            </div>
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Questions Section-->
                            <div class="mb-6">
                                <h4 class="fs-6 fw-semibold mb-4">Available Question Types</h4>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-sm btn-light-info" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_text_question_{{ $page->id }}">
                                        <i class="ki-duotone ki-text-box fs-2"></i>
                                        Text
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light-warning" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_choice_question_{{ $page->id }}">
                                        <i class="ki-duotone ki-choose fs-2"></i>
                                        Multiple Choice
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light-success" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_file_question_{{ $page->id }}">
                                        <i class="ki-duotone ki-file fs-2"></i>
                                        File Upload
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_date_question_{{ $page->id }}">
                                        <i class="ki-duotone ki-calendar fs-2"></i>
                                        Date
                                    </button>
                                </div>
                            </div>
                            <!--end::Questions Section-->

                            <!--begin::Questions List-->
                            <div class="mb-6">
                                <h4 class="fs-6 fw-semibold mb-4">Current Questions</h4>
                                @if ($page->questions->count() > 0)
                                    <div class="d-flex flex-column gap-3">
                                        @foreach ($page->questions()->ordered()->get() as $question)
                                            <div class="card card-bordered border-gray-300">
                                                <div class="card-body py-3">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex flex-column">
                                                            <span
                                                                class="fw-bold text-dark">{{ $question->question }}</span>
                                                            <div class="d-flex align-items-center gap-2 mt-1">
                                                                <span
                                                                    class="badge badge-light-{{ $question->required ? 'danger' : 'success' }}">
                                                                    {{ $question->required ? 'Required' : 'Optional' }}
                                                                </span>
                                                                <span class="badge badge-light-primary">
                                                                    Score: {{ $question->score }}
                                                                </span>
                                                                <span class="badge badge-light-info">
                                                                    {{ $question->field_type->name }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex gap-2">
                                                            <button type="button"
                                                                class="btn btn-icon btn-sm btn-light-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#kt_modal_edit_question_{{ $question->id }}">
                                                                <i class="ki-duotone ki-pencil fs-2"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-icon btn-sm btn-light-danger"
                                                                data-action="delete-question"
                                                                data-question-id="{{ $question->id }}">
                                                                <i class="ki-duotone ki-trash fs-2"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div
                                        class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                                        <i class="ki-duotone ki-information fs-2tx text-warning me-4"></i>
                                        <div class="d-flex flex-stack flex-grow-1">
                                            <div class="fw-semibold">
                                                <h4 class="text-gray-900 fw-bold">No Questions Yet</h4>
                                                <div class="fs-6 text-gray-700">Click one of the question type buttons above
                                                    to add your first question to this page.</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!--end::Questions List-->
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                <!--end::Page Card-->
            @endforeach
        </div>
        <!--end::Pages Grid-->
    </div>
    <!--end::Pages Section-->

    <!-- Add Page Modal -->
    <div class="modal fade" id="kt_modal_add_page" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Add New Page</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"></i>
                    </div>
                </div>
                <form id="kt_modal_add_page_form" class="form" {{-- action="{{ route(Program::ui['route'] . '.' . ProgramPage::ui['route'] . '.store', ['program' => $_model->id]) }}" --}} method="POST">
                    @csrf
                    <div class="modal-body py-10 px-lg-17">
                        <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_add_page_header"
                            data-kt-scroll-wrappers="#kt_modal_add_page_scroll" data-kt-scroll-offset="300px">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Page Title</label>
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Enter page title" name="title" required />
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold mb-2">Page Order</label>
                                <input type="number" class="form-control form-control-solid"
                                    placeholder="Enter page order" name="order"
                                    value="{{ $_model->pages->count() + 1 }}" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">Cancel</button>
                        <button type="submit" id="kt_modal_add_page_submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    {{-- -------------- --}}
    <!-- Text Question Modal -->
    @foreach ($_model->pages as $page)
        <div class="modal fade" id="kt_modal_add_text_question_{{ $page->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold">Add Text Question</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"></i>
                        </div>
                    </div>
                    <form class="form">
                        <input type="hidden" name="program_page_id" value="{{ $page->id }}">
                        <div class="modal-body py-10 px-lg-17">
                            <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-max-height="auto">
                                <div class="fv-row mb-7">
                                    <label class="required fs-6 fw-semibold mb-2">Question Text</label>
                                    <input type="text" class="form-control form-control-solid" name="question"
                                        required />
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold mb-2">Score</label>
                                    <input type="number" class="form-control form-control-solid" name="score"
                                        value="0" min="0" />
                                </div>
                                <div class="fv-row">
                                    <label class="form-check form-check-custom form-check-solid mb-2">
                                        <input class="form-check-input" type="checkbox" name="required"
                                            value="1" />
                                        <span class="form-check-label">Required Field</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer flex-center">
                            <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Multiple Choice Question Modal -->
        <div class="modal fade" id="kt_modal_add_choice_question_{{ $page->id }}" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold">Add Multiple Choice Question</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"></i>
                        </div>
                    </div>
                    <form class="form">
                        <input type="hidden" name="program_page_id" value="{{ $page->id }}">
                        <div class="modal-body py-10 px-lg-17">
                            <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-max-height="auto">
                                <div class="fv-row mb-7">
                                    <label class="required fs-6 fw-semibold mb-2">Question Text</label>
                                    <input type="text" class="form-control form-control-solid" name="question"
                                        required />
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="required fs-6 fw-semibold mb-2">Options</label>
                                    <div class="options-container">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="options[]"
                                                placeholder="Enter option">
                                            <button type="button" class="btn btn-light-danger remove-option">
                                                <i class="ki-duotone ki-trash fs-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-light-primary add-option-btn">
                                        <i class="ki-duotone ki-plus fs-2"></i>
                                        Add Option
                                    </button>
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold mb-2">Score</label>
                                    <input type="number" class="form-control form-control-solid" name="score"
                                        value="0" min="0" />
                                </div>
                                <div class="fv-row">
                                    <label class="form-check form-check-custom form-check-solid mb-2">
                                        <input class="form-check-input" type="checkbox" name="required"
                                            value="1" />
                                        <span class="form-check-label">Required Field</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer flex-center">
                            <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- File Upload Question Modal -->
        <div class="modal fade" id="kt_modal_add_file_question_{{ $page->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold">Add File Upload Question</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"></i>
                        </div>
                    </div>
                    <form class="form">
                        <input type="hidden" name="program_page_id" value="{{ $page->id }}">
                        <div class="modal-body py-10 px-lg-17">
                            <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-max-height="auto">
                                <div class="fv-row mb-7">
                                    <label class="required fs-6 fw-semibold mb-2">Question Text</label>
                                    <input type="text" class="form-control form-control-solid" name="question"
                                        required />
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold mb-2">Allowed File Types</label>
                                    <input type="text" class="form-control form-control-solid" name="allowed_types"
                                        placeholder="pdf,doc,docx" />
                                    <div class="text-muted fs-7">Comma separated file extensions</div>
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold mb-2">Maximum File Size (MB)</label>
                                    <input type="number" class="form-control form-control-solid" name="max_size"
                                        value="5" min="1" />
                                </div>
                                <div class="fv-row mb-7">
                                    <!-- Continuation of File Upload Question Modal -->
                                    <label class="fs-6 fw-semibold mb-2">Score</label>
                                    <input type="number" class="form-control form-control-solid" name="score"
                                        value="0" min="0" />
                                </div>
                                <div class="fv-row">
                                    <label class="form-check form-check-custom form-check-solid mb-2">
                                        <input class="form-check-input" type="checkbox" name="required"
                                            value="1" />
                                        <span class="form-check-label">Required Field</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer flex-center">
                            <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Date Question Modal -->
        <div class="modal fade" id="kt_modal_add_date_question_{{ $page->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold">Add Date Question</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"></i>
                        </div>
                    </div>
                    <form class="form">
                        <input type="hidden" name="program_page_id" value="{{ $page->id }}">
                        <div class="modal-body py-10 px-lg-17">
                            <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-max-height="auto">
                                <div class="fv-row mb-7">
                                    <label class="required fs-6 fw-semibold mb-2">Question Text</label>
                                    <input type="text" class="form-control form-control-solid" name="question"
                                        required />
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold mb-2">Minimum Date</label>
                                    <input type="date" class="form-control form-control-solid" name="min_date" />
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold mb-2">Maximum Date</label>
                                    <input type="date" class="form-control form-control-solid" name="max_date" />
                                </div>
                                <div class="fv-row mb-7">
                                    <label class="fs-6 fw-semibold mb-2">Score</label>
                                    <input type="number" class="form-control form-control-solid" name="score"
                                        value="0" min="0" />
                                </div>
                                <div class="fv-row">
                                    <label class="form-check form-check-custom form-check-solid mb-2">
                                        <input class="form-check-input" type="checkbox" name="required"
                                            value="1" />
                                        <span class="form-check-label">Required Field</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer flex-center">
                            <button type="reset" data-bs-dismiss="modal" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <script>
        // Initialize all forms validation and submission
        const initForms = () => {
            // Add Page Form
            const addPageForm = document.querySelector('#kt_modal_add_page_form');
            if (addPageForm) {
                const validator = FormValidation.formValidation(addPageForm, {
                    fields: {
                        'title': {
                            validators: {
                                notEmpty: {
                                    message: 'Page title is required'
                                }
                            }
                        },
                        'order': {
                            validators: {
                                notEmpty: {
                                    message: 'Page order is required'
                                },
                                numeric: {
                                    message: 'Order must be a number'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                });

                const submitButton = addPageForm.querySelector('#kt_modal_add_page_submit');
                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    validator.validate().then(function(status) {
                        if (status === 'Valid') {
                            submitButton.setAttribute('data-kt-indicator', 'on');
                            submitButton.disabled = true;

                            const formData = new FormData(addPageForm);
                            fetch(addPageForm.getAttribute('action'), {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            text: "Page has been successfully added!",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        }).then(function() {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            text: "Sorry, there was an error, please try again.",
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                    }
                                })
                                .catch(() => {
                                    Swal.fire({
                                        text: "Sorry, there was an error, please try again.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                })
                                .finally(() => {
                                    submitButton.removeAttribute('data-kt-indicator');
                                    submitButton.disabled = false;
                                });
                        }
                    });
                });
            }
        };

        // Handle delete operations
        const handleDelete = () => {
            // Delete page
            document.querySelectorAll('[data-action="delete-page"]').forEach(button => {
                button.addEventListener('click', e => {
                    e.preventDefault();
                    const pageId = button.getAttribute('data-page-id');

                    Swal.fire({
                        text: "Are you sure you want to delete this page?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/programs/${programId}/pages/${pageId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]')
                                            .getAttribute('content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            text: "Page has been deleted!",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        }).then(function() {
                                            location.reload();
                                        });
                                    }
                                });
                        }
                    });
                });
            });

            // Delete question
            document.querySelectorAll('[data-action="delete-question"]').forEach(button => {
                button.addEventListener('click', e => {
                    e.preventDefault();
                    const questionId = button.getAttribute('data-question-id');
                    const pageId = button.closest('[data-page-id]').getAttribute('data-page-id');

                    Swal.fire({
                        text: "Are you sure you want to delete this question?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/programs/${programId}/pages/${pageId}/questions/${questionId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]')
                                            .getAttribute('content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            text: "Question has been deleted!",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        }).then(function() {
                                            location.reload();
                                        });
                                    }
                                })
                                .catch(() => {
                                    Swal.fire({
                                        text: "Sorry, there was an error, please try again.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                });
                        }
                    });
                });
            });
        };

        // Initialize question type modals
        const initQuestionModals = () => {
            // Text Question Modal Handler
            document.querySelectorAll('[data-bs-target^="#kt_modal_add_text_question_"]').forEach(button => {
                const modal = document.querySelector(button.getAttribute('data-bs-target'));
                if (modal) {
                    const form = modal.querySelector('form');
                    const submitBtn = form.querySelector('[type="submit"]');

                    submitBtn.addEventListener('click', e => {
                        e.preventDefault();
                        const formData = new FormData(form);
                        formData.append('field_type_id', 1); // Assuming 1 is text type

                        submitQuestion(formData, submitBtn);
                    });
                }
            });

            // Multiple Choice Question Modal Handler
            document.querySelectorAll('[data-bs-target^="#kt_modal_add_choice_question_"]').forEach(button => {
                const modal = document.querySelector(button.getAttribute('data-bs-target'));
                if (modal) {
                    const form = modal.querySelector('form');
                    const submitBtn = form.querySelector('[type="submit"]');
                    const optionsContainer = form.querySelector('.options-container');
                    const addOptionBtn = form.querySelector('.add-option-btn');

                    // Add new option field
                    addOptionBtn.addEventListener('click', () => {
                        const optionField = document.createElement('div');
                        optionField.className = 'input-group mb-3';
                        optionField.innerHTML = `
                    <input type="text" class="form-control" name="options[]" placeholder="Enter option">
                    <button type="button" class="btn btn-light-danger remove-option">
                        <i class="ki-duotone ki-trash fs-2"></i>
                    </button>
                `;
                        optionsContainer.appendChild(optionField);
                    });

                    // Remove option field
                    optionsContainer.addEventListener('click', e => {
                        if (e.target.closest('.remove-option')) {
                            e.target.closest('.input-group').remove();
                        }
                    });

                    submitBtn.addEventListener('click', e => {
                        e.preventDefault();
                        const formData = new FormData(form);
                        formData.append('field_type_id', 2); // Assuming 2 is multiple choice type

                        submitQuestion(formData, submitBtn);
                    });
                }
            });

            // File Upload Question Modal Handler
            document.querySelectorAll('[data-bs-target^="#kt_modal_add_file_question_"]').forEach(button => {
                const modal = document.querySelector(button.getAttribute('data-bs-target'));
                if (modal) {
                    const form = modal.querySelector('form');
                    const submitBtn = form.querySelector('[type="submit"]');

                    submitBtn.addEventListener('click', e => {
                        e.preventDefault();
                        const formData = new FormData(form);
                        formData.append('field_type_id', 3); // Assuming 3 is file type

                        submitQuestion(formData, submitBtn);
                    });
                }
            });

            // Date Question Modal Handler
            document.querySelectorAll('[data-bs-target^="#kt_modal_add_date_question_"]').forEach(button => {
                const modal = document.querySelector(button.getAttribute('data-bs-target'));
                if (modal) {
                    const form = modal.querySelector('form');
                    const submitBtn = form.querySelector('[type="submit"]');

                    submitBtn.addEventListener('click', e => {
                        e.preventDefault();
                        const formData = new FormData(form);
                        formData.append('field_type_id', 4); // Assuming 4 is date type

                        submitQuestion(formData, submitBtn);
                    });
                }
            });
        };

        // Helper function to submit questions
        const submitQuestion = (formData, submitBtn) => {
            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;

            fetch(`/programs/${programId}/questions`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            text: "Question has been successfully added!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then(function() {
                            location.reload();
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        text: "Sorry, there was an error, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                })
                .finally(() => {
                    submitBtn.removeAttribute('data-kt-indicator');
                    submitBtn.disabled = false;
                });
        };

        // Initialize all components
        document.addEventListener('DOMContentLoaded', function() {
            initForms();
            handleDelete();
            initQuestionModals();
        });
    </script>
@endpush
