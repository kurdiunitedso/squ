@extends('CP.metronic.index')

@section('title', t('leads'))
@section('subpageTitle', t('leads'))
@push('css')
    <style>
        .form-field-card {
            border: 1px solid #eee;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            background: white;
        }

        .form-field-card:hover {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .field-type-btn {
            width: 100%;
            margin-bottom: 10px;
            text-align: left;
        }

        .drag-handle {
            cursor: move;
            color: #a1a5b7;
        }
    </style>
@endpush
@section('content')


    <!-- Begin Form Generator -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Program Form Generator</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light-primary me-3" id="previewForm">
                    <i class="fas fa-eye"></i> Preview
                </button>
                <button type="button" class="btn btn-sm btn-primary" id="saveForm">
                    <i class="fas fa-save"></i> Save Form
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Form Elements Sidebar -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Elements</h3>
                        </div>
                        <div class="card-body">
                            <!-- Basic Fields -->
                            <div class="mb-5">
                                <h5 class="fw-bold mb-3">Basic Fields</h5>
                                <button class="btn btn-light-primary field-type-btn" data-field-type="text">
                                    <i class="fas fa-font me-2"></i> Text Input
                                </button>
                                <button class="btn btn-light-primary field-type-btn" data-field-type="textarea">
                                    <i class="fas fa-paragraph me-2"></i> Text Area
                                </button>
                                <button class="btn btn-light-primary field-type-btn" data-field-type="number">
                                    <i class="fas fa-hashtag me-2"></i> Number
                                </button>
                                <button class="btn btn-light-primary field-type-btn" data-field-type="email">
                                    <i class="fas fa-envelope me-2"></i> Email
                                </button>
                                <button class="btn btn-light-primary field-type-btn" data-field-type="phone">
                                    <i class="fas fa-phone me-2"></i> Phone
                                </button>
                            </div>

                            <!-- Advanced Fields -->
                            <div class="mb-5">
                                <h5 class="fw-bold mb-3">Advanced Fields</h5>
                                <button class="btn btn-light-primary field-type-btn" data-field-type="select">
                                    <i class="fas fa-list me-2"></i> Dropdown
                                </button>
                                <button class="btn btn-light-primary field-type-btn" data-field-type="radio">
                                    <i class="fas fa-dot-circle me-2"></i> Radio Buttons
                                </button>
                                <button class="btn btn-light-primary field-type-btn" data-field-type="checkbox">
                                    <i class="fas fa-check-square me-2"></i> Checkboxes
                                </button>
                                <button class="btn btn-light-primary field-type-btn" data-field-type="file">
                                    <i class="fas fa-file-upload me-2"></i> File Upload
                                </button>
                            </div>

                            <!-- Special Fields -->
                            <div class="mb-5">
                                <h5 class="fw-bold mb-3">Special Fields</h5>
                                <button class="btn btn-light-primary field-type-btn" data-field-type="repeater">
                                    <i class="fas fa-layer-group me-2"></i> Repeater
                                </button>
                                <button class="btn btn-light-primary field-type-btn" data-field-type="section">
                                    <i class="fas fa-folder me-2"></i> Section
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Building Area -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Structure</h3>
                        </div>
                        <div class="card-body">
                            <!-- Form Basic Info -->
                            <!-- Replace the Form Title section with this -->
                            <div class="mb-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" data-bs-toggle="tab"
                                                    data-bs-target="#title-en" type="button">English</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#title-ar"
                                                    type="button">العربية</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content mt-2">
                                            <div class="tab-pane fade show active" id="title-en">
                                                <div class="mb-3">
                                                    <label class="form-label">Form Title (English)</label>
                                                    <input type="text" class="form-control" id="formTitle_en"
                                                        placeholder="Enter form title">
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="title-ar">
                                                <div class="mb-3">
                                                    <label class="form-label">Form Title (Arabic)</label>
                                                    <input type="text" class="form-control" id="formTitle_ar"
                                                        placeholder="أدخل عنوان النموذج" dir="rtl">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Program Category</label>
                                            <select class="form-control" id="programCategory">
                                                <option value="">Select category</option>
                                                <option value="innovation">Innovation</option>
                                                <option value="research">Research</option>
                                                <option value="entrepreneurship">Entrepreneurship</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Form Steps -->
                            <div class="mb-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold">Form Steps</h5>
                                    <button type="button" class="btn btn-sm btn-light-primary" id="addStep">
                                        <i class="fas fa-plus"></i> Add Step
                                    </button>
                                </div>
                                <div id="formSteps" class="accordion">
                                    <!-- Steps will be added here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Replace your current field settings modal with this -->
    <div class="modal fade" id="fieldSettingsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Field Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Tabs for languages -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#en-field"
                                type="button">English</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#ar-field"
                                type="button">العربية</button>
                        </li>
                    </ul>

                    <form id="fieldSettingsForm">
                        <div class="tab-content">
                            <!-- English Fields -->
                            <div class="tab-pane fade show active" id="en-field">
                                <div class="mb-3">
                                    <label class="form-label">Field Label (English)</label>
                                    <input type="text" class="form-control" id="fieldLabel_en" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Placeholder (English)</label>
                                    <input type="text" class="form-control" id="fieldPlaceholder_en">
                                </div>
                            </div>

                            <!-- Arabic Fields -->
                            <div class="tab-pane fade" id="ar-field">
                                <div class="mb-3">
                                    <label class="form-label">Field Label (Arabic)</label>
                                    <input type="text" class="form-control" id="fieldLabel_ar" required
                                        dir="rtl">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Placeholder (Arabic)</label>
                                    <input type="text" class="form-control" id="fieldPlaceholder_ar" dir="rtl">
                                </div>
                            </div>
                        </div>

                        <!-- Common Settings -->
                        <div class="mb-3">
                            <label class="form-label">Field Name (API reference)</label>
                            <input type="text" class="form-control" id="fieldName" required>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="required">
                                <label class="form-check-label">Required Field</label>
                            </div>
                        </div>

                        <!-- Field-specific Settings -->
                        <div id="fieldSpecificSettings"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveFieldSettings">Save Settings</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script>
        // Core form generator functionality
        class FormGenerator {
            constructor() {
                this.formStructure = {
                    title: {
                        en: '',
                        ar: ''
                    },
                    category: '',
                    steps: []
                };
                this.currentEditingField = null;
                this.locales = ['en', 'ar'];
                this.initializeEventListeners();
            }
            // Update the field settings modal HTML to support multiple languages
            getFieldSettingsHTML(fieldType) {
                return `
            <form id="fieldSettingsForm">
                <!-- Tabs for languages -->
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#en-field" type="button">English</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#ar-field" type="button">العربية</button>
                    </li>
                </ul>

                <!-- Tab content -->
                <div class="tab-content">
                    <!-- English Fields -->
                    <div class="tab-pane fade show active" id="en-field">
                        <div class="mb-3">
                            <label class="form-label">Field Label (English)</label>
                            <input type="text" class="form-control" id="fieldLabel_en" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Placeholder (English)</label>
                            <input type="text" class="form-control" id="fieldPlaceholder_en">
                        </div>
                    </div>

                    <!-- Arabic Fields -->
                    <div class="tab-pane fade" id="ar-field">
                        <div class="mb-3">
                            <label class="form-label">Field Label (Arabic)</label>
                            <input type="text" class="form-control" id="fieldLabel_ar" required dir="rtl">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Placeholder (Arabic)</label>
                            <input type="text" class="form-control" id="fieldPlaceholder_ar" dir="rtl">
                        </div>
                    </div>
                </div>

                <!-- Common Settings -->
                <div class="mb-3">
                    <label class="form-label">Field Name (API reference)</label>
                    <input type="text" class="form-control" id="fieldName" required>
                </div>

                <!-- Validation Settings -->
                <div class="mb-3">
                    <label class="form-label">Validation Rules</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="required">
                        <label class="form-check-label">Required Field</label>
                    </div>
                    <div id="additionalValidation"></div>
                </div>

                <!-- Field-specific Settings -->
                <div id="fieldSpecificSettings"></div>
            </form>
        `;
            }
            initializeEventListeners() {
                // Add step button
                document.getElementById('addStep')?.addEventListener('click', () => this.addStep());

                // Save form button
                document.getElementById('saveForm')?.addEventListener('click', () => this.saveForm());

                // Preview form button
                document.getElementById('previewForm')?.addEventListener('click', () => this.previewForm());

                // Field type buttons
                document.querySelectorAll('[data-field-type]').forEach(button => {
                    button.addEventListener('click', (e) => this.handleFieldTypeClick(e));
                });

                // Initialize field settings modal events
                document.getElementById('saveFieldSettings')?.addEventListener('click', () => this.saveFieldSettings());

                // Global event delegation for dynamic elements
                document.addEventListener('click', (e) => {
                    if (e.target.closest('.edit-field')) {
                        const fieldCard = e.target.closest('.form-field-card');
                        this.editField(fieldCard);
                    } else if (e.target.closest('.delete-field')) {
                        const fieldCard = e.target.closest('.form-field-card');
                        this.deleteField(fieldCard);
                    } else if (e.target.closest('.delete-step')) {
                        const stepItem = e.target.closest('.accordion-item');
                        this.deleteStep(stepItem);
                    }
                });
            }
            addStep() {
                const stepId = 'step_' + Date.now();
                const stepTitles = {
                    en: 'New Step',
                    ar: 'خطوة جديدة'
                };

                const stepHtml = `
        <div class="accordion-item" data-step-id="${stepId}" data-title-en="${stepTitles.en}" data-title-ar="${stepTitles.ar}">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#${stepId}">
                    <i class="fas fa-grip-vertical drag-handle me-2"></i>
                    <span class="step-title">${stepTitles.en} / ${stepTitles.ar}</span>
                </button>
            </h2>
            <div id="${stepId}" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <div class="mb-3">
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#step-title-en-${stepId}">English</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#step-title-ar-${stepId}">العربية</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="step-title-en-${stepId}">
                                <input type="text" class="form-control step-title-input-en" value="${stepTitles.en}" placeholder="Step Title (English)">
                            </div>
                            <div class="tab-pane fade" id="step-title-ar-${stepId}">
                                <input type="text" class="form-control step-title-input-ar" value="${stepTitles.ar}" placeholder="عنوان الخطوة" dir="rtl">
                            </div>
                        </div>
                    </div>
                    <div class="form-fields-container">
                        <!-- Fields will be added here -->
                    </div>
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-sm btn-light-danger delete-step">
                            <i class="fas fa-trash"></i> Delete Step
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

                document.getElementById('formSteps').insertAdjacentHTML('beforeend', stepHtml);

                // Get the newly added step element
                const stepElement = document.querySelector(`[data-step-id="${stepId}"]`);

                // Initialize sortable for the fields container
                this.initializeSortable(stepElement.querySelector('.form-fields-container'));

                // Add event listeners for step title changes
                const updateStepTitle = () => {
                    const titleEn = stepElement.querySelector('.step-title-input-en')?.value || stepTitles.en;
                    const titleAr = stepElement.querySelector('.step-title-input-ar')?.value || stepTitles.ar;
                    stepElement.dataset.titleEn = titleEn;
                    stepElement.dataset.titleAr = titleAr;
                    stepElement.querySelector('.step-title').textContent = `${titleEn} / ${titleAr}`;
                };

                stepElement.querySelector('.step-title-input-en')?.addEventListener('input', updateStepTitle);
                stepElement.querySelector('.step-title-input-ar')?.addEventListener('input', updateStepTitle);
            }

            handleFieldTypeClick(e) {
                const fieldType = e.target.dataset.fieldType;
                const activeStep = document.querySelector('.accordion-collapse.show');
                if (activeStep) {
                    this.addField(fieldType, activeStep.querySelector('.form-fields-container'));
                } else {
                    toastr.warning('Please select or create a step first');
                }
            }

            addField(type, container, fieldData = {}) {
                const fieldId = 'field_' + Date.now();
                const defaultLabels = {
                    en: `New ${type} Field`,
                    ar: `حقل ${type} جديد`
                };

                const fieldHtml = `
        <div class="form-field-card"
             data-field-id="${fieldId}"
             data-field-type="${type}"
             data-labels='${JSON.stringify(fieldData.labels || defaultLabels)}'
             data-placeholders='${JSON.stringify(fieldData.placeholders || {"en":"","ar":""})}'
        >
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <i class="fas fa-grip-vertical drag-handle me-2"></i>
                    <span class="field-label">${defaultLabels.en} / ${defaultLabels.ar}</span>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-icon btn-light-primary edit-field me-2">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-icon btn-light-danger delete-field">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="field-preview"></div>
        </div>
    `;
                container.insertAdjacentHTML('beforeend', fieldHtml);
            }
            editField(fieldCard) {
                this.currentEditingField = fieldCard;
                const fieldType = fieldCard.dataset.fieldType;

                // Get stored labels and placeholders
                const labels = JSON.parse(fieldCard.dataset.labels || '{"en":"","ar":""}');
                const placeholders = JSON.parse(fieldCard.dataset.placeholders || '{"en":"","ar":""}');

                // Populate modal fields
                document.getElementById('fieldLabel_en').value = labels.en;
                document.getElementById('fieldLabel_ar').value = labels.ar;
                document.getElementById('fieldPlaceholder_en').value = placeholders.en;
                document.getElementById('fieldPlaceholder_ar').value = placeholders.ar;
                document.getElementById('fieldName').value = fieldCard.dataset.fieldName || '';
                document.getElementById('required').checked = fieldCard.dataset.required === 'true';

                // Show field-specific settings
                this.showFieldSpecificSettings(fieldType);

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('fieldSettingsModal'));
                modal.show();
            }

            deleteField(fieldCard) {
                if (confirm('Are you sure you want to delete this field?')) {
                    fieldCard.remove();
                    this.updateFormStructure();
                }
            }

            deleteStep(stepItem) {
                if (confirm('Are you sure you want to delete this step?')) {
                    stepItem.remove();
                    this.updateFormStructure();
                }
            }

            previewForm() {
                // Update form structure before preview
                this.updateFormStructure();

                // Create modal HTML for preview
                const modalHtml = `
        <div class="modal fade" id="previewFormModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        ${this.generateFormPreviewHTML()}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `;

                // Remove existing preview modal if any
                const existingModal = document.getElementById('previewFormModal');
                if (existingModal) {
                    existingModal.remove();
                }

                // Add modal to document
                document.body.insertAdjacentHTML('beforeend', modalHtml);

                // Show modal
                const previewModal = new bootstrap.Modal(document.getElementById('previewFormModal'));
                previewModal.show();
            }
            generateFormPreviewHTML() {
                // Get form title in both languages
                const titleEn = this.formStructure.title.en || 'Untitled Form';
                const titleAr = this.formStructure.title.ar || 'نموذج بدون عنوان';

                let html = `
        <h4>${titleEn} / ${titleAr}</h4>
        <p class="text-muted">Category: ${this.formStructure.category || 'Uncategorized'}</p>
    `;

                if (this.formStructure.steps.length === 0) {
                    return html + '<div class="alert alert-info">No steps added to the form yet.</div>';
                }

                html += '<div class="preview-steps">';
                this.formStructure.steps.forEach((step, index) => {
                    // Get step title in both languages
                    const stepTitleEn = step.title.en || `Step ${index + 1}`;
                    const stepTitleAr = step.title.ar || `الخطوة ${index + 1}`;

                    html += `
            <div class="preview-step mb-4">
                <h5 class="mb-3">${stepTitleEn} / ${stepTitleAr}</h5>
                <div class="preview-fields">
                    ${this.generateStepFieldsPreviewHTML(step.fields)}
                </div>
            </div>
        `;
                });
                html += '</div>';

                return html;
            }

            generateStepFieldsPreviewHTML(fields) {
                if (!fields.length) {
                    return '<div class="alert alert-info">No fields added to this step yet.</div>';
                }

                return fields.map(field => {
                    const required = field.required ? 'required' : '';
                    let fieldHtml = '';

                    try {
                        // Extract labels for the current field
                        const labels = field.labels || {
                            en: '',
                            ar: ''
                        };
                        const labelDisplay = `${labels.en} / ${labels.ar}`;

                        switch (field.type) {
                            case 'text':
                            case 'email':
                            case 'phone':
                            case 'number':
                                fieldHtml = `
                        <div class="mb-3">
                            <label class="form-label">${labelDisplay} ${required ? '<span class="text-danger">*</span>' : ''}</label>
                            <input type="${field.type}" class="form-control" name="${field.name}" ${required} disabled>
                        </div>
                    `;
                                break;

                            case 'textarea':
                                fieldHtml = `
                        <div class="mb-3">
                            <label class="form-label">${labelDisplay} ${required ? '<span class="text-danger">*</span>' : ''}</label>
                            <textarea class="form-control" name="${field.name}" rows="3" ${required} disabled></textarea>
                        </div>
                    `;
                                break;

                            case 'select':
                                const selectOptions = field.options || {
                                    en: [],
                                    ar: []
                                };
                                fieldHtml = `
                        <div class="mb-3">
                            <label class="form-label">${labelDisplay} ${required ? '<span class="text-danger">*</span>' : ''}</label>
                            <select class="form-control" name="${field.name}" ${required} disabled>
                                <option value="">Select an option / اختر خيارًا</option>
                                ${selectOptions.en.map((opt, index) => `
                                                                    <option value="${opt.value}">${opt.label} / ${selectOptions.ar[index]?.label || ''}</option>
                                                                `).join('')}
                            </select>
                        </div>
                    `;
                                break;

                            case 'radio':
                                const radioOptions = field.options || {
                                    en: [],
                                    ar: []
                                };
                                fieldHtml = `
                        <div class="mb-3">
                            <label class="form-label">${labelDisplay} ${required ? '<span class="text-danger">*</span>' : ''}</label>
                            ${radioOptions.en.map((opt, index) => `
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="${field.name}" value="${opt.value}" ${required} disabled>
                                                                    <label class="form-check-label">${opt.label} / ${radioOptions.ar[index]?.label || ''}</label>
                                                                </div>
                                                            `).join('')}
                        </div>
                    `;
                                break;

                            case 'checkbox':
                                const checkboxOptions = field.options || {
                                    en: [],
                                    ar: []
                                };
                                fieldHtml = `
                        <div class="mb-3">
                            <label class="form-label">${labelDisplay} ${required ? '<span class="text-danger">*</span>' : ''}</label>
                            ${checkboxOptions.en.map((opt, index) => `
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="${field.name}[]" value="${opt.value}" disabled>
                                                                    <label class="form-check-label">${opt.label} / ${checkboxOptions.ar[index]?.label || ''}</label>
                                                                </div>
                                                            `).join('')}
                        </div>
                    `;
                                break;

                            case 'file':
                                fieldHtml = `
                        <div class="mb-3">
                            <label class="form-label">${labelDisplay} ${required ? '<span class="text-danger">*</span>' : ''}</label>
                            <input type="file" class="form-control" name="${field.name}"
                                   ${field.allowedTypes ? `accept="${field.allowedTypes}"` : ''} ${required} disabled>
                            ${field.allowedTypes ? `<small class="text-muted">Allowed types: ${field.allowedTypes}</small>` : ''}
                        </div>
                    `;
                                break;

                            case 'repeater':
                                fieldHtml = `
                        <div class="mb-3">
                            <label class="form-label">${labelDisplay} ${required ? '<span class="text-danger">*</span>' : ''}</label>
                            <div class="repeater-preview border rounded p-3">
                                <small class="text-muted">Repeater fields will be rendered here</small>
                            </div>
                            <button type="button" class="btn btn-light-primary btn-sm mt-2" disabled>
                                Add Item / إضافة عنصر
                            </button>
                        </div>
                    `;
                                break;
                        }

                        return fieldHtml;
                    } catch (error) {
                        console.error('Error generating preview for field:', field, error);
                        return `<div class="alert alert-danger">Error generating preview for field</div>`;
                    }
                }).join('');
            }
            // Update save field settings to handle multiple languages
            saveFieldSettings() {
                if (!this.currentEditingField) return;

                const fieldData = {
                    label: {
                        en: document.getElementById('fieldLabel_en').value,
                        ar: document.getElementById('fieldLabel_ar').value
                    },
                    placeholder: {
                        en: document.getElementById('fieldPlaceholder_en').value,
                        ar: document.getElementById('fieldPlaceholder_ar').value
                    },
                    name: document.getElementById('fieldName').value,
                    required: document.getElementById('required').checked
                };

                // Update field card display (show current language or both)
                const labelDisplay = `${fieldData.label.en} / ${fieldData.label.ar}`;
                this.currentEditingField.querySelector('.field-label').textContent = labelDisplay;

                // Store all data in dataset
                this.currentEditingField.dataset.fieldName = fieldData.name;
                this.currentEditingField.dataset.required = fieldData.required;
                this.currentEditingField.dataset.labels = JSON.stringify(fieldData.label);
                this.currentEditingField.dataset.placeholders = JSON.stringify(fieldData.placeholder);

                // Handle field-specific settings
                this.saveFieldTypeSpecificSettings(this.currentEditingField);

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('fieldSettingsModal'));
                modal.hide();

                // Update preview
                this.updateFieldPreview(this.currentEditingField);

                // Update form structure
                this.updateFormStructure();
            }
            // Helper method to save field-specific settings
            saveFieldTypeSpecificSettings(fieldCard) {
                const fieldType = fieldCard.dataset.fieldType;

                switch (fieldType) {
                    case 'select':
                    case 'radio':
                    case 'checkbox':
                        const options = {
                            en: this.getOptionsFromContainer('en'),
                            ar: this.getOptionsFromContainer('ar')
                        };
                        fieldCard.dataset.options = JSON.stringify(options);
                        break;

                    case 'file':
                        fieldCard.dataset.allowedTypes = document.getElementById('allowedTypes').value;
                        fieldCard.dataset.maxFileSize = document.getElementById('maxFileSize').value;
                        break;
                }
            }

            // Helper method to get options from container
            getOptionsFromContainer(locale) {
                const container = document.getElementById(`optionsContainer_${locale}`);
                return Array.from(container.querySelectorAll('.option-row')).map(row => ({
                    label: row.querySelector(`[name="options_${locale}[]"]`).value,
                    value: row.querySelector(`[name="values_${locale}[]"]`).value
                }));
            }
            showFieldSpecificSettings(fieldType) {
                const container = document.getElementById('fieldSpecificSettings');
                let html = '';

                switch (fieldType) {
                    case 'select':
                    case 'radio':
                    case 'checkbox':
                        html = this.getOptionsSettingsHTML();
                        break;
                    case 'file':
                        html = this.getFileSettingsHTML();
                        break;
                        // Add other field type settings as needed
                }

                container.innerHTML = html;
                this.initializeFieldSpecificEvents(fieldType, container);
            }
            // Update the initializeFieldSpecificEvents method
            initializeFieldSpecificEvents(fieldType, container) {
                switch (fieldType) {
                    case 'select':
                    case 'radio':
                    case 'checkbox':
                        // Add option buttons
                        container.querySelectorAll('[class="add-option-btn"]').forEach(btn => {
                            btn.addEventListener('click', () => {
                                const locale = btn.dataset.locale;
                                this.addOptionRow(container.querySelector(
                                    `#optionsContainer_${locale}`), locale);
                            });
                        });

                        // Remove option buttons
                        container.querySelectorAll('.remove-option').forEach(btn => {
                            btn.addEventListener('click', (e) => this.removeOptionRow(e));
                        });
                        break;

                    case 'file':
                        this.initializeFileUploadSettings(container);
                        break;

                    case 'repeater':
                        this.initializeRepeaterSettings(container);
                        break;
                }
            }

            // Update the addOptionRow method to handle locales
            addOptionRow(container, locale) {
                const newRow = document.createElement('div');
                newRow.className = 'option-row mb-2';

                // Set different placeholders based on locale
                const placeholders = {
                    en: {
                        label: "Option Label",
                        value: "Value"
                    },
                    ar: {
                        label: "خيار",
                        value: "القيمة"
                    }
                };

                newRow.innerHTML = `
        <div class="input-group">
            <input type="text" class="form-control" placeholder="${placeholders[locale].label}" name="options_${locale}[]">
            <input type="text" class="form-control" placeholder="${placeholders[locale].value}" name="values_${locale}[]">
            <button type="button" class="btn btn-light-danger remove-option">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

                container.appendChild(newRow);
                newRow.querySelector('.remove-option').addEventListener('click', (e) => this.removeOptionRow(e));
            }

            addOptionRow(container) {
                const newRow = document.createElement('div');
                newRow.className = 'option-row mb-2';
                newRow.innerHTML = `
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Option Label" name="options[]">
            <input type="text" class="form-control" placeholder="Value" name="values[]">
            <button type="button" class="btn btn-light-danger remove-option">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
                container.appendChild(newRow);
                newRow.querySelector('.remove-option').addEventListener('click', (e) => this.removeOptionRow(e));
            }
            // Update the removeOptionRow method
            removeOptionRow(e) {
                const optionsContainer = e.target.closest('.option-row').parentElement;
                if (optionsContainer.querySelectorAll('.option-row').length > 1) {
                    e.target.closest('.option-row').remove();
                }
            }

            getFileSettingsHTML() {
                return `
        <div class="mb-3">
            <label class="form-label">Allowed File Types</label>
            <input type="text" class="form-control" id="allowedTypes" placeholder="pdf,doc,docx">
            <small class="text-muted">Enter file extensions separated by commas</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Max File Size (MB)</label>
            <input type="number" class="form-control" id="maxFileSize" value="2">
        </div>
    `;
            }

            initializeFileUploadSettings(container) {
                const allowedTypesInput = container.querySelector('#allowedTypes');
                const maxFileSizeInput = container.querySelector('#maxFileSize');

                if (this.currentEditingField) {
                    allowedTypesInput.value = this.currentEditingField.dataset.allowedTypes || '';
                    maxFileSizeInput.value = this.currentEditingField.dataset.maxFileSize || '2';
                }
            }

            updateFieldPreview(fieldCard) {
                const previewContainer = fieldCard.querySelector('.field-preview');
                const fieldType = fieldCard.dataset.fieldType;
                const label = fieldCard.querySelector('.field-label').textContent;
                const required = fieldCard.dataset.required === 'true';

                let previewHTML = '';
                switch (fieldType) {
                    case 'text':
                    case 'email':
                    case 'phone':
                    case 'number':
                        previewHTML = `
                <div class="preview-field">
                    <input type="${fieldType}" class="form-control" placeholder="${label}" ${required ? 'required' : ''} disabled>
                </div>
            `;
                        break;

                    case 'textarea':
                        previewHTML = `
                <div class="preview-field">
                    <textarea class="form-control" placeholder="${label}" ${required ? 'required' : ''} disabled></textarea>
                </div>
            `;
                        break;

                    case 'select':
                        previewHTML = `
                <div class="preview-field">
                    <select class="form-control" ${required ? 'required' : ''} disabled>
                        <option value="">${label}</option>
                    </select>
                </div>
            `;
                        break;

                    case 'file':
                        previewHTML = `
                <div class="preview-field">
                    <input type="file" class="form-control" ${required ? 'required' : ''} disabled>
                </div>
            `;
                        break;
                }

                previewContainer.innerHTML = previewHTML;
            }
            getOptionsSettingsHTML() {
                return `
        <div class="mb-3">
            <label class="form-label">Options</label>
            <!-- Tabs for languages -->
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#en-options" type="button">English</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#ar-options" type="button">العربية</button>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content">
                <!-- English Options -->
                <div class="tab-pane fade show active" id="en-options">
                    <div id="optionsContainer_en">
                        <div class="option-row mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Option Label" name="options_en[]">
                                <input type="text" class="form-control" placeholder="Value" name="values_en[]">
                                <button type="button" class="btn btn-light-danger remove-option">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-light-primary btn-sm mt-2" data-locale="en" class="add-option-btn">
                        <i class="fas fa-plus"></i> Add Option
                    </button>
                </div>

                <!-- Arabic Options -->
                <div class="tab-pane fade" id="ar-options">
                    <div id="optionsContainer_ar" dir="rtl">
                        <div class="option-row mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="خيار" name="options_ar[]">
                                <input type="text" class="form-control" placeholder="القيمة" name="values_ar[]">
                                <button type="button" class="btn btn-light-danger remove-option">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-light-primary btn-sm mt-2" data-locale="ar" class="add-option-btn">
                        <i class="fas fa-plus"></i> إضافة خيار
                    </button>
                </div>
            </div>
        </div>
    `;
            }

            initializeSortable(container) {
                if (window.Sortable) {
                    new Sortable(container, {
                        animation: 150,
                        handle: '.drag-handle',
                        onEnd: () => this.updateFormStructure()
                    });
                } else {
                    console.error('Sortable library not loaded');
                }
            }

            generateFieldName(label) {
                return label.toLowerCase()
                    .replace(/[^a-z0-9]/g, '_')
                    .replace(/_{2,}/g, '_')
                    .replace(/^_|_$/g, '');
            }


            updateFormStructure() {
                // Initialize the form structure
                this.formStructure = {
                    title: {
                        en: document.getElementById('formTitle_en')?.value || '',
                        ar: document.getElementById('formTitle_ar')?.value || ''
                    },
                    category: document.getElementById('programCategory')?.value || '',
                    steps: []
                };

                // Collect all steps
                document.querySelectorAll('.accordion-item').forEach(stepEl => {
                    const step = {
                        id: stepEl.dataset.stepId,
                        title: {
                            en: stepEl.dataset.titleEn || '',
                            ar: stepEl.dataset.titleAr || ''
                        },
                        fields: []
                    };

                    // Collect all fields in this step
                    stepEl.querySelectorAll('.form-field-card').forEach(fieldEl => {
                        try {
                            const field = {
                                id: fieldEl.dataset.fieldId || '',
                                type: fieldEl.dataset.fieldType || '',
                                name: fieldEl.dataset.fieldName || '',
                                labels: JSON.parse(fieldEl.dataset.labels || '{"en":"","ar":""}'),
                                placeholder: JSON.parse(fieldEl.dataset.placeholders ||
                                    '{"en":"","ar":""}'),
                                required: fieldEl.dataset.required === 'true'
                            };

                            // Add field-specific data
                            if (['select', 'radio', 'checkbox'].includes(field.type)) {
                                field.options = JSON.parse(fieldEl.dataset.options ||
                                    '{"en":[],"ar":[]}');
                            }

                            if (field.type === 'file') {
                                field.allowedTypes = fieldEl.dataset.allowedTypes || '';
                                field.maxFileSize = fieldEl.dataset.maxFileSize || '';
                            }

                            step.fields.push(field);
                        } catch (error) {
                            console.error('Error processing field:', error);
                        }
                    });

                    this.formStructure.steps.push(step);
                });

                return this.formStructure;
            }
            saveForm() {
                this.updateFormStructure();
                console.log('Form Structure:', this.formStructure);
                // Here you would typically send this to your backend
                toastr.success('Form structure saved successfully');
            }
        }

        // Initialize form generator when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            window.formGenerator = new FormGenerator();
        });
    </script>
@endpush
