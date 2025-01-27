@php
    use App\Models\Program;
    use App\Models\ProgramPage;
@endphp
@extends('CP.metronic.index')
@section('title', 'Form Builder')

@push('css')
    <style>
        .stepper.stepper-pills .stepper-item .stepper-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            background-color: #f5f8fa;
            border: 0;
        }

        .stepper.stepper-pills .stepper-item.current .stepper-icon {
            background-color: #7239ea;
            color: #ffffff;
        }

        .field-card {
            border: 1px solid #eee;
            border-radius: 8px;
            margin-bottom: 1rem;
            background: white;
        }

        .field-card:hover {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .options-list .input-group {
            margin-bottom: 0.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3>Form Builder</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route($program::ui['route'] . '.' . ProgramPage::ui['route'] . '.create', ['program' => $program->id]) }}"
                    class="btn btn-sm btn-light-primary me-3" id="add_{{ ProgramPage::ui['s_lcf'] }}_modal">
                    <i class="fas fa-plus"></i> Add Page
                </a>
                <button type="button" class="btn btn-sm btn-light-info me-3" id="showFormPreview">
                    <i class="fas fa-eye"></i> Show Form
                </button>
                <button type="button" class="btn btn-sm btn-primary" id="saveForm">
                    <i class="fas fa-save"></i> Save Form
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="mb-10 d-flex flex-center">
                <div class="stepper stepper-pills">
                    <div class="stepper-nav justify-content-center gap-6" id="pageNumbers"></div>
                </div>
            </div>

            <div id="pageContent" class="mt-10">
                <!-- Page content will be loaded here -->
            </div>

            {{-- <div class="text-center mt-5">
                <button type="button" class="btn btn-light-primary" id="addPage">
                    <i class="fas fa-plus"></i> Add New Page
                </button>
            </div> --}}
        </div>
    </div>

    <!-- Question Template -->
    <template id="questionTemplate">
        <div class="field-card p-6 mb-4" data-question-id="">
            <div class="row mb-5">
                <div class="col-md-4">
                    <label class="form-label">Field Type</label>
                    <select class="form-select field-type">
                        @foreach ($fieldTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Question (English)</label>
                            <input type="text" class="form-control question-en">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Question (Arabic)</label>
                            <input type="text" class="form-control question-ar" dir="rtl">
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-icon btn-light-danger delete-question">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <div class="options-container d-none">
                <div class="options-list mb-3"></div>
                <button type="button" class="btn btn-sm btn-light-primary add-option">
                    <i class="fas fa-plus"></i> Add Option
                </button>
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input question-required">
                <label class="form-check-label">Required Field</label>
            </div>
        </div>
    </template>

@endsection

@push('scripts')
    {{-- // Add new page --}}
    <script>
        $(document).on('click', "#add_{{ ProgramPage::ui['s_lcf'] }}_modal", function(e) {
            e.preventDefault();
            const button = $(this);
            button.attr("data-kt-indicator", "on");
            const url = button.attr('href');
            ModalRenderer.render({
                url: url,
                button: button,
                modalId: '#kt_modal_general',
                modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general')),
                formId: '#{{ ProgramPage::ui['s_lcf'] }}_modal_form',
                dataTableId: null,
                submitButtonName: "[data-kt-modal-action='submit_{{ ProgramPage::ui['s_lcf'] }}']",
                onFormSuccessCallBack: (response) => {
                    // Reload the pages
                    loadPages();

                    // If you want to show a success message
                    toastr.success('Page created successfully');

                    // If you need to reset any other UI elements or state
                    currentPage = null;
                    $('#pageContent').empty();
                }
            });
        });
    </script>


    {{-- Load pages --}}
    <script>
        function loadPages() {
            const programId = {{ $program->id }};
            // Use the correct route name based on the UI constants
            const route = `{{ route(Program::ui['route'] . '.pages', ['program' => ':programId']) }}`
                .replace(':programId', programId);

            $.ajax({
                url: route,
                method: 'GET',
                success: function(response) {
                    renderPageNumbers(response);
                    if (response.length > 0) {
                        loadPageContent(response[0].id);
                    } else {
                        $('#pageContent').empty();
                    }
                },
                error: function(xhr) {
                    toastr.error('Error loading pages');
                }
            });
        }

        function renderPageNumbers(pages) {
            console.log('renderPageNumbers(pages)', pages);

            const container = $('#pageNumbers');
            container.empty();

            pages.forEach((page, index) => {
                const pageElement = $(`
            <div class="stepper-item cursor-pointer" data-page-id="${page.id}">
                <div class="stepper-icon">${index + 1}</div>
                <div class="stepper-label mt-2">${page.title?.en || 'New Page'}</div>
            </div>
        `);

                if (index === 0) {
                    pageElement.addClass('current');
                }

                container.append(pageElement);
            });
        }

        function loadPageContent(pageId) {
            const programId = {{ $program->id }};
            // Use the correct route name based on the UI constants
            const route =
                `{{ route(Program::ui['route'] . '.pages.content', ['program' => ':programId', 'page' => ':pageId']) }}`
                .replace(':programId', programId)
                .replace(':pageId', pageId);

            $.ajax({
                url: route,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        currentPage = response.data;
                        renderPageContent(response.data);
                    }
                },
                error: function(xhr) {
                    toastr.error('Error loading page content');
                }
            });
        }
    </script>

    <script>
        // Initialize variables
        let currentPage = null;
        const programId = {{ $program->id }};

        // Document ready handler
        $(document).ready(function() {
            loadPages();

            $('#saveForm').click(function(e) {
                e.preventDefault();
                saveForm();
            });

            $(document).on('click', '.stepper-item', function() {
                $('.stepper-item').removeClass('current');
                $(this).addClass('current');
                loadPageContent($(this).data('page-id'));
            });
        });

        function saveForm() {
            if (!currentPage) return;

            const programId = {{ $program->id }};
            // Use the correct route name based on the UI constants
            const route =
                `{{ route(Program::ui['route'] . '.pages.save', ['program' => ':programId', 'page' => ':pageId']) }}`
                .replace(':programId', programId)
                .replace(':pageId', currentPage.id);

            const data = {
                title: {
                    en: $('[name="title_en"]').val(),
                    ar: $('[name="title_ar"]').val()
                },
                questions: collectQuestions()
            };

            $.ajax({
                url: route,
                method: 'POST',
                data: data,
                success: function(response) {
                    if (response.success) {
                        toastr.success('Form saved successfully');
                        loadPages();
                    }
                },
                error: function(xhr) {
                    toastr.error('Error saving form');
                }
            });
        }
        // Add this function for rendering page content
        function renderPageContent(page) {
            // Render the page title section
            $('#pageContent').html(`
        <div class="row mb-8">
            <div class="col-md-6">
                <label class="form-label">Page Title (English)</label>
                <input type="text" class="form-control" name="title_en"
                       value="${page.title?.en || ''}" placeholder="Enter page title">
            </div>
            <div class="col-md-6">
                <label class="form-label">Page Title (Arabic)</label>
                <input type="text" class="form-control" name="title_ar"
                       value="${page.title?.ar || ''}" placeholder="أدخل عنوان الصفحة" dir="rtl">
            </div>
        </div>

        <div id="questionsContainer"></div>

        <button type="button" class="btn btn-light-primary mt-5" id="addQuestion">
            <i class="fas fa-plus"></i> Add Question
        </button>
    `);

            // Render each question if they exist
            if (page.questions && page.questions.length > 0) {
                page.questions.forEach(renderQuestion);
            }
        }

        function renderQuestion(question) {
            const template = document.getElementById('questionTemplate');
            const questionElement = $(template.content.cloneNode(true));

            // Set the question ID
            questionElement.find('.field-card').attr('data-question-id', question.id);

            // Set field type
            questionElement.find('.field-type').val(question.field_type_id);

            // Set questions in both languages
            questionElement.find('.question-en').val(question.question.en);
            questionElement.find('.question-ar').val(question.question.ar);

            // Set required checkbox
            questionElement.find('.question-required').prop('checked', question.required);

            // Handle options if they exist
            const optionsContainer = questionElement.find('.options-container');
            const optionsList = questionElement.find('.options-list');

            if (question.options && (Array.isArray(question.options.en) || Array.isArray(question.options.ar))) {
                optionsContainer.removeClass('d-none');

                // Get the maximum length between English and Arabic options
                const maxOptions = Math.max(
                    Array.isArray(question.options.en) ? question.options.en.length : 0,
                    Array.isArray(question.options.ar) ? question.options.ar.length : 0
                );

                // Render each option
                for (let i = 0; i < maxOptions; i++) {
                    const optionHtml = `
                <div class="input-group mb-3 option-row">
                    <input type="text" class="form-control option-text-en"
                           value="${question.options.en?.[i] || ''}"
                           placeholder="Option in English">
                    <input type="text" class="form-control option-text-ar" dir="rtl"
                           value="${question.options.ar?.[i] || ''}"
                           placeholder="الخيار بالعربية">
                    <button class="btn btn-icon btn-light-danger delete-option">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
                    optionsList.append(optionHtml);
                }
            }

            // Append the question to the container
            $('#questionsContainer').append(questionElement.find('.field-card'));
        }
    </script>
    <script>
        // Add the event handler for adding options
        $(document).on('click', '.add-option', function() {
            const optionsList = $(this).siblings('.options-list');
            const newOptionHtml = `
        <div class="input-group mb-3 option-row">
            <input type="text" class="form-control option-text-en" placeholder="Option in English">
            <input type="text" class="form-control option-text-ar" dir="rtl" placeholder="الخيار بالعربية">
            <button class="btn btn-icon btn-light-danger delete-option">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
            optionsList.append(newOptionHtml);
        });

        // Add the event handler for deleting options
        $(document).on('click', '.delete-option', function() {
            $(this).closest('.option-row').remove();
        });

        // Handle field type changes
        $(document).on('change', '.field-type', function() {
            const card = $(this).closest('.field-card');
            const optionsContainer = card.find('.options-container');
            const fieldTypeId = $(this).val();

            // Show options container for select, checkbox, and radio types
            // You'll need to adjust these IDs based on your actual field type IDs
            const optionTypes = [21, 22, 23]; // Example IDs for select, checkbox, radio
            if (optionTypes.includes(parseInt(fieldTypeId))) {
                optionsContainer.removeClass('d-none');
            } else {
                optionsContainer.addClass('d-none');
            }
        });
    </script>
    <script>
        // Initialize the show form handler
        $(document).on('click', '#showFormPreview', function() {
            loadFormPreview();
        });

        function loadFormPreview() {
            const programId = {{ $program->id }};
            const route = `{{ route(Program::ui['route'] . '.pages', ['program' => ':programId']) }}`
                .replace(':programId', programId);

            $.ajax({
                url: route,
                method: 'GET',
                success: function(pages) {
                    showFormPreviewModal(pages);
                },
                error: function(xhr) {
                    toastr.error('Error loading form preview');
                }
            });
        }

        function showFormPreviewModal(pages) {
            // Create modal content
            const modalContent = `
    <div class="modal fade" id="formPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="previewForm">
                        <div class="stepper stepper-pills">
                            <div class="stepper-nav mb-5">
                                ${pages.map((page, index) => `
                                                                    <div class="stepper-item me-5 ${index === 0 ? 'current' : ''}" data-preview-page="${index}">
                                                                        <div class="stepper-icon">${index + 1}</div>
                                                                        <div class="stepper-label">${page.title?.en || 'Untitled'}</div>
                                                                    </div>
                                                                `).join('')}
                            </div>

                            <div class="stepper-content">
                                ${pages.map((page, index) => `
                                                                    <div class="preview-page" id="previewPage${index}" ${index === 0 ? '' : 'style="display: none;"'}>
                                                                        <h3 class="mb-5">${page.title?.en || 'Untitled'}</h3>
                                                                        <div class="questions-container" id="previewQuestions${index}">
                                                                            Loading questions...
                                                                        </div>
                                                                    </div>
                                                                `).join('')}
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>`;

            // Add modal to body and show it
            $('body').append(modalContent);
            const modal = new bootstrap.Modal(document.getElementById('formPreviewModal'));
            modal.show();

            // Load questions for each page
            pages.forEach((page, index) => {
                loadPreviewPageQuestions(page, index);
            });

            // Handle page navigation
            $(document).on('click', '.stepper-item[data-preview-page]', function() {
                const pageIndex = $(this).data('preview-page');
                $('.stepper-item[data-preview-page]').removeClass('current');
                $(this).addClass('current');
                $('.preview-page').hide();
                $(`#previewPage${pageIndex}`).show();
            });

            // Clean up when modal is hidden
            $('#formPreviewModal').on('hidden.bs.modal', function() {
                $(this).remove();
            });
        }

        function loadPreviewPageQuestions(page, pageIndex) {
            const programId = {{ $program->id }};
            const route =
                `{{ route(Program::ui['route'] . '.' . 'pages.content', ['program' => ':programId', 'page' => ':pageId']) }}`
                .replace(':programId', programId)
                .replace(':pageId', page.id);

            $.ajax({
                url: route,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        renderPreviewQuestions(response.data.questions, pageIndex);
                    }
                },
                error: function(xhr) {
                    $(`#previewQuestions${pageIndex}`).html('Error loading questions');
                }
            });
        }

        function renderPreviewQuestions(questions, pageIndex) {
            const questionsHtml = questions.map(question => {
                let inputHtml = '';

                switch (question.field_type_id) {
                    case 21: // Select
                        inputHtml = `
                    <select class="form-select" ${question.required ? 'required' : ''}>
                        <option value="">Select an option</option>
                        ${question.options.en.map(option => `
                                                            <option value="${option}">${option}</option>
                                                        `).join('')}
                    </select>`;
                        break;
                    case 19: // Text input
                        inputHtml = `
                    <input type="text" class="form-control"
                           ${question.required ? 'required' : ''}>`;
                        break;
                        // Add more field types as needed
                }

                return `
            <div class="mb-5">
                <label class="form-label">
                    ${question.question.en}
                    ${question.required ? '<span class="text-danger">*</span>' : ''}
                </label>
                ${inputHtml}
            </div>`;
            }).join('');

            $(`#previewQuestions${pageIndex}`).html(questionsHtml);
        }
    </script>
@endpush
