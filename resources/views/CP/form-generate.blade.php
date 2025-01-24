@extends('CP.metronic.index')
@section('title', 'Form Builder')
@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h3>Form Builder</h3>
            </div>
            <div class="card-toolbar">
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

            <div class="text-center mt-5">
                <button type="button" class="btn btn-light-primary" id="addPage">
                    <i class="fas fa-plus"></i> Add New Page
                </button>
            </div>
        </div>
    </div>
@endsection

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

@push('scripts')
    <script>
        let currentPages = [];
        const questionTypes = [{
                value: 'text',
                label: 'Text Input'
            },
            {
                value: 'textarea',
                label: 'Wide Text'
            },
            {
                value: 'select',
                label: 'Dropdown List'
            },
            {
                value: 'checkbox',
                label: 'Checkbox'
            },
            {
                value: 'tags',
                label: 'Tags'
            },
            {
                value: 'repeater',
                label: 'Repeater List'
            },
            {
                value: 'file',
                label: 'File Upload'
            }
        ];
        // Save page data before switching
        function savePage(pageId) {
            const pageData = {
                title: {
                    en: $('[name="title_en"]').val(),
                    ar: $('[name="title_ar"]').val()
                },
                fields: collectFieldsData(pageId)
            };
            localStorage.setItem(`page_${pageId}`, JSON.stringify(pageData));
        }

        function initializePages() {
            const stepperNav = $('#pageNumbers');
            stepperNav.empty();

            currentPages.forEach((page, index) => {
                stepperNav.append(`
    <div class="stepper-item ${index === 0 ? 'current' : ''}" data-page-id="${page.id}">
        <div class="stepper-icon">
            ${index + 1}
        </div>
        <div class="stepper-label mt-2">${page.title?.en || 'New Page'}</div>
    </div>
`);
            });
        }
        // Clear saved data when deleting page
        function deletePage(pageId) {
            if (confirm('Delete this page?')) {
                localStorage.removeItem(`page_${pageId}`);
                currentPages = currentPages.filter(p => p.id !== pageId);
                initializePages();
                if (currentPages.length > 0) {
                    showPageContent(currentPages[0].id);
                } else {
                    $('#pageContent').empty();
                }
            }
        }

        function showPageContent(pageId) {
            const savedData = localStorage.getItem(`page_${pageId}`);
            const page = savedData ? JSON.parse(savedData) : currentPages.find(p => p.id === pageId);

            // Save current page before switching
            const currentPageId = $('.stepper-item.current').data('page-id');
            if (currentPageId) {
                savePage(currentPageId);
            }

            $('#pageContent').html(`
        <div class="card">
             <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Page Settings</h3>
                <button type="button" class="btn btn-sm btn-danger" onclick="deletePage(${pageId})">
                    <i class="fas fa-trash"></i> Delete Page
                </button>
            </div>
            <div class="card-body">
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

                <div id="fieldsContainer" class="mb-8">
                    ${renderFields(page.fields || [])}
                </div>

                <button type="button" class="btn btn-light-primary" onclick="addField(${pageId})">
                    <i class="fas fa-plus"></i> Add Field
                </button>
            </div>
        </div>
    `);
        }
        // Add this function
        function updatePageTitles() {
            currentPages = currentPages.map(page => {
                page.title = {
                    en: $(`[name="title_en"]`).val(),
                    ar: $(`[name="title_ar"]`).val()
                };
                return page;
            });
            initializePages();
        }

        // Add these event listeners in initializeEventHandlers
        $('[name="title_en"], [name="title_ar"]').on('input', updatePageTitles);

        function addField(pageId) {
            const fieldId = Date.now();
            const field = {
                id: fieldId,
                type: 'text',
                name: '',
                required: false,
                options: []
            };

            const pageIndex = currentPages.findIndex(p => p.id === pageId);
            if (pageIndex > -1) {
                if (!currentPages[pageIndex].fields) {
                    currentPages[pageIndex].fields = [];
                }
                currentPages[pageIndex].fields.push(field);
                $('#fieldsContainer').html(renderFields(currentPages[pageIndex].fields));
            }
        }

        function renderFields(fields) {
            return fields.map(field => `
        <div class="field-card p-6" data-field-id="${field.id}">
            <div class="row mb-5">
                <div class="col-md-4">
                    <select class="form-select field-type">
                        ${questionTypes.map(type =>
                            `<option value="${type.value}" ${field.type === type.value ? 'selected' : ''}>
                                                                                        ${type.label}
                                                                                    </option>`
                        ).join('')}
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control field-name"
                        placeholder="Field Name" value="${field.name || ''}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-icon btn-light-danger delete-field">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <div class="field-options ${['select', 'checkbox', 'tags'].includes(field.type) ? '' : 'd-none'}">
                <div class="options-list mb-3">
                    ${renderOptions(field.options)}
                </div>
                <button type="button" class="btn btn-sm btn-light-primary add-option">
                    <i class="fas fa-plus"></i> Add Option
                </button>
            </div>

            <div class="form-check mt-3">
                <input type="checkbox" class="form-check-input field-required"
                    ${field.required ? 'checked' : ''}>
                <label class="form-check-label">Required Field</label>
            </div>
        </div>
    `).join('');
        }

        function renderOptions(options = []) {
            return options.map((option, index) => `
        <div class="input-group mb-3">
            <input type="text" class="form-control option-text"
                placeholder="Option Text" value="${option.text || ''}">
            <input type="number" class="form-control option-score"
                placeholder="Score" value="${option.score || 0}">
            <button class="btn btn-icon btn-light-danger delete-option">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `).join('');
        }

        $(document).ready(function() {
            $('#addPage').click(() => {
                const newPage = {
                    id: Date.now(),
                    title: {
                        en: '',
                        ar: ''
                    },
                    fields: []
                };
                currentPages.push(newPage);
                initializePages();
                showPageContent(newPage.id);
            });

            $(document).on('click', '.stepper-item', function() {
                $('.stepper-item').removeClass('current');
                $(this).addClass('current');
                showPageContent($(this).data('page-id'));
            });

            // Event handlers for field management
            initializeEventHandlers();
        });

        function initializeEventHandlers() {
            // Your existing event handlers here
            // Add field type change handler
            $(document).on('change', '.field-type', function() {
                const fieldCard = $(this).closest('.field-card');
                const type = $(this).val();

                if (['select', 'checkbox', 'tags'].includes(type)) {
                    fieldCard.find('.field-options').removeClass('d-none');
                } else {
                    fieldCard.find('.field-options').addClass('d-none');
                }
            });

            // Add option handler
            $(document).on('click', '.add-option', function() {
                const optionsList = $(this).siblings('.options-list');
                optionsList.append(renderOptions([{
                    text: '',
                    score: 0
                }]));
            });

            // Delete handlers
            $(document).on('click', '.delete-field', function() {
                $(this).closest('.field-card').remove();
                updateFormStructure();
            });

            $(document).on('click', '.delete-option', function() {
                $(this).closest('.input-group').remove();
                updateFormStructure();
            });

            // Save form handler
            $('#saveForm').click(updateFormStructure);
        }

        function updateFormStructure() {
            currentPages.forEach(page => {
                savePage(page.id);
            });
            // Collect form data and send to server
            const formData = {
                pages: currentPages.map(page => ({
                    id: page.id,
                    title: {
                        en: $(`[data-page-id="${page.id}"] [name="title_en"]`).val(),
                        ar: $(`[data-page-id="${page.id}"] [name="title_ar"]`).val()
                    },
                    fields: collectFieldsData(page.id)
                }))
            };

            $.ajax({
                method: 'POST',
                data: {
                    structure: formData
                },
                success: response => {
                    toastr.success('Form saved successfully');
                },
                error: xhr => {
                    toastr.error('Error saving form');
                }
            });
        }

        function collectFieldsData(pageId) {
            const fields = [];
            $(`[data-page-id="${pageId}"] .field-card`).each(function() {
                const field = {
                    id: $(this).data('field-id'),
                    type: $(this).find('.field-type').val(),
                    name: $(this).find('.field-name').val(),
                    required: $(this).find('.field-required').prop('checked'),
                    options: []
                };

                $(this).find('.options-list .input-group').each(function() {
                    field.options.push({
                        text: $(this).find('.option-text').val(),
                        score: $(this).find('.option-score').val()
                    });
                });

                fields.push(field);
            });
            return fields;
        }
    </script>
@endpush
