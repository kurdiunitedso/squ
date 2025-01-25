<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
@php
    use App\Models\Program;
    use App\Models\ProgramPage;
@endphp

<script>
    class FormGenerator {
        constructor() {


            this.formStructure = {
                fields: []
            };
            this.currentEditingField = null;
            this.initializeEventListeners();

        }
        initializeEventListeners() {
            $('[data-field-type]').on('click', e => this.handleFieldTypeClick(e));
            $('#saveFieldSettings').on('click', () => this.saveFieldSettings());

            $(document).on('click', '.edit-field', e => {
                this.editField($(e.target).closest('.form-field-card'));
            });

            $(document).on('click', '.delete-field', e => {
                this.deleteField($(e.target).closest('.form-field-card'));
            });

            $(document).on('click', '.delete-option', e => {
                $(e.target).closest('.option-row').remove();
            });

            $(document).on('click', '.add-option', e => {
                const optionsContainer = $(e.target).closest('.field-options').find('.options-container');
                this.addOptionRow(optionsContainer);
            });
        }

        addOptionRow(container) {
            const optionRow = `
            <div class="row option-row mb-2">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Label" name="option_label[]">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Value" name="option_value[]">
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-sm btn-danger delete-option">×</button>
                </div>
            </div>`;
            container.append(optionRow);
        }
        handleFieldTypeClick(e) {
            const fieldType = $(e.target).data('field-type');
            this.addField(fieldType);
        }

        addField(type) {
            const fieldId = 'field_' + Date.now();
            const fieldHtml = `
            <div class="form-field-card mb-3" data-field-id="${fieldId}" data-field-type="${type}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>${type}</div>
                            <div>
                                <button type="button" class="btn btn-sm btn-icon btn-light-primary edit-field me-2">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-icon btn-light-danger delete-field">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="field-preview mt-2"></div>
                        ${type === 'select' ? `
                            <div class="field-options mt-3">
                                <div class="options-container"></div>
                                <button type="button" class="btn btn-sm btn-primary add-option mt-2">Add Option</button>
                            </div>
                        ` : ''}
                    </div>
                </div>
            </div>`;
            $('.form-fields-container').append(fieldHtml);

            if (type === 'select') {
                const optionsContainer = $(`[data-field-id="${fieldId}"]`).find('.options-container');
                this.addOptionRow(optionsContainer);
            }

            this.updateFormStructure();
        }
        editField($fieldCard) {
            this.currentEditingField = $fieldCard;
            $('#fieldLabel').val($fieldCard.data('label') || '');
            $('#fieldName').val($fieldCard.data('name') || '');
            $('#required').prop('checked', $fieldCard.data('required') === true);

            new bootstrap.Modal('#fieldSettingsModal').show();
        }

        deleteField($fieldCard) {
            if (confirm('Delete this field?')) {
                $fieldCard.remove();
                this.updateFormStructure();
            }
        }

        saveFieldSettings() {
            if (!this.currentEditingField) return;

            const $field = $(this.currentEditingField);
            const label = $('#fieldLabel').val();
            const name = $('#fieldName').val();
            const required = $('#required').is(':checked');

            $field.data({
                label: label,
                name: name,
                required: required
            });

            const fieldType = $field.data('field-type');
            let previewHtml = `<div class="text-muted">Label: ${label}</div>`;

            if (fieldType === 'select') {
                const options = $field.find('.option-row').map((i, row) => {
                    const $row = $(row);
                    return {
                        label: $row.find('[name="option_label[]"]').val(),
                        value: $row.find('[name="option_value[]"]').val()
                    };
                }).get();
                $field.data('options', options);
            }

            $field.find('.field-preview').html(previewHtml);
            bootstrap.Modal.getInstance('#fieldSettingsModal').hide();
            this.updateFormStructure();
        }
        updateFormStructure() {
            this.formStructure.fields = $('.form-field-card').map((i, el) => {
                const $el = $(el);
                const fieldData = {
                    id: $el.data('field-id'),
                    type: $el.data('field-type'),
                    required: $el.data('required') === true,
                    label: $el.data('label') || '',
                    name: $el.data('name') || ''
                };

                if (fieldData.type === 'select') {
                    fieldData.options = $el.find('.option-row').map((i, row) => {
                        const $row = $(row);
                        return {
                            label: $row.find('[name="option_label[]"]').val(),
                            value: $row.find('[name="option_value[]"]').val()
                        };
                    }).get();
                }

                return fieldData;
            }).get();
            return this.formStructure;
        }
        init(formStructure) {
            this.fields = []; // Reset fields array
            this.formStructure = formStructure;
            this.initializeFieldTypes();
            this.setupEventListeners();
            this.renderFormBuilder();
        }

        initializeFieldTypes() {
            this.fieldTypes = {
                text: {
                    label: 'Text Input',
                    icon: 'text-width'
                },
                email: {
                    label: 'Email Input',
                    icon: 'envelope'
                },
                phone: {
                    label: 'Phone Input',
                    icon: 'phone'
                },
                textarea: {
                    label: 'Text Area',
                    icon: 'paragraph'
                },
                select: {
                    label: 'Dropdown',
                    icon: 'chevron-down'
                },
                multiselect: {
                    label: 'Multi Select',
                    icon: 'list-check'
                },
                repeater: {
                    label: 'Form Repeater',
                    icon: 'copy'
                },
                date: {
                    label: 'Date Picker',
                    icon: 'calendar'
                },
                file: {
                    label: 'File Upload',
                    icon: 'upload'
                },
                checkbox: {
                    label: 'Checkbox',
                    icon: 'check-square'
                },
                radio: {
                    label: 'Radio Button',
                    icon: 'circle-dot'
                }
            };
        }

        setupEventListeners() {
            // Remove previous event listeners to prevent multiple bindings
            $(document).off('click', '.add-field-btn');
            $(document).off('click', '.remove-field-btn');
            $(document).off('click', '#save-form-btn');

            $(document).on('click', '.add-field-btn', (e) => {
                e.preventDefault(); // Prevent default button behavior
                const fieldType = $(e.currentTarget).data('type');
                // Check if field already exists
                if (!this.fields.some(field => field.type === fieldType)) {
                    this.addField(fieldType);
                }
            });

            $(document).on('click', '.remove-field-btn', (e) => {
                const fieldId = $(e.currentTarget).closest('.form-field').data('field-id');
                this.removeField(fieldId);
            });

            $(document).on('click', '#save-form-btn', () => {
                this.saveForm();
            });
        }

        renderFormBuilder() {
            const container = $('#form-generator-container');
            container.empty();

            const buttonsHtml = Object.entries(this.fieldTypes).map(([type, config]) => `
            <button class="btn btn-light-primary btn-sm m-2 add-field-btn" data-type="${type}">
                <i class="fas fa-${config.icon} me-2"></i>${config.label}
            </button>
        `).join('');

            const formHtml = `
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Generator</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col">${buttonsHtml}</div>
                    </div>
                    <div id="form-fields-container" class="border rounded p-4"></div>
                    <div class="text-end mt-5">
                        <button id="save-form-btn" class="btn btn-primary">Save Form Structure</button>
                    </div>
                </div>
            </div>
        `;

            container.html(formHtml);
            this.loadExistingStructure();
        }

        loadExistingStructure() {
            if (this.formStructure) {
                this.fields = []; // Clear existing fields
                const existingFields = JSON.parse(this.formStructure);
                existingFields.forEach(field => {
                    // Create new field with unique ID
                    const fieldId = Date.now() + Math.floor(Math.random() * 1000);
                    const newField = {
                        ...field,
                        id: fieldId
                    };
                    this.fields.push(newField);
                    this.renderField(newField);
                });
            }
        }

        addField(type, existingData = null) {
            const fieldId = Date.now();
            const field = this.createFieldConfig(type, fieldId, existingData);
            this.fields.push(field);
            this.renderField(field);
        }

        createFieldConfig(type, fieldId, existingData) {
            const baseConfig = {
                id: fieldId,
                type: type,
                label: existingData?.label || '',
                name: existingData?.name || '',
                required: existingData?.required || false,
                placeholder: existingData?.placeholder || '',
                validations: existingData?.validations || []
            };

            switch (type) {
                case 'select':
                case 'multiselect':
                    return {
                        ...baseConfig, options: existingData?.options || []
                    };
                case 'repeater':
                    return {
                        ...baseConfig, fields: existingData?.fields || []
                    };
                default:
                    return baseConfig;
            }
        }

        renderField(field) {
            const fieldHtml = this.generateFieldHtml(field);
            $('#form-fields-container').append(fieldHtml);
            this.initializeFieldComponents(field);
        }

        generateFieldHtml(field) {
            const commonFields = `
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Label</label>
                    <input type="text" class="form-control field-label"
                           placeholder="Enter field label" value="${field.label}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control field-name"
                           placeholder="Enter field name" value="${field.name}">
                </div>
            </div>
        `;

            const validationFields = `
            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input field-required" type="checkbox"
                               ${field.required ? 'checked' : ''}>
                        <label class="form-check-label">Required</label>
                    </div>
                </div>
            </div>
        `;

            let specificFields = '';
            if (field.type === 'select' || field.type === 'multiselect') {
                specificFields = this.generateOptionsHtml(field);
            } else if (field.type === 'repeater') {
                specificFields = this.generateRepeaterHtml(field);
            }

            return `
            <div class="form-field card mb-4" data-field-id="${field.id}">
                <div class="card-header cursor-move">
                    <h3 class="card-title">${this.fieldTypes[field.type].label}</h3>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-sm btn-light-danger remove-field-btn">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    ${commonFields}
                    ${validationFields}
                    ${specificFields}
                </div>
            </div>
        `;
        }
        generateOptionsHtml(field) {
            const optionsHtml = field.options?.map(option => `
        <div data-repeater-item class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control option-label" placeholder="Option Label" value="${option.label || ''}">
                <input type="text" class="form-control option-value" placeholder="Option Value" value="${option.value || ''}">
                <button class="btn btn-danger" data-repeater-delete type="button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `).join('') || '';

            return `
    <div class="row mb-3">
        <div class="col-12">
            <div class="repeater" data-repeater-instance>
                <div data-repeater-list="options">
                    ${optionsHtml}
                </div>
                <button class="btn btn-light-primary btn-sm" data-repeater-create type="button">Add Option</button>
            </div>
        </div>
    </div>`;
        }

        generateRepeaterHtml(field) {
            return `
            <div class="repeater-fields mb-3">
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Repeater Fields</label>
                        <div data-repeater-list="repeater_fields">
                            ${(field.fields || []).map(subField => `
                                <div data-repeater-item class="mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control mb-2"
                                                           placeholder="Field Label" value="${subField.label || ''}">
                                                </div>
                                                <div class="col-md-5">
                                                    <select class="form-select field-type mb-2">
                                                        ${Object.entries(this.fieldTypes).map(([type, config]) => `
                                                            <option value="${type}" ${subField.type === type ? 'selected' : ''}>
                                                                ${config.label}
                                                            </option>
                                                        `).join('')}
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-danger" data-repeater-delete type="button">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                        <button class="btn btn-light-primary btn-sm" data-repeater-create type="button">
                            Add Repeater Field
                        </button>
                    </div>
                </div>
            </div>
        `;
        }

        initializeFieldComponents(field) {
            const fieldElement = $(`.form-field[data-field-id="${field.id}"]`);
            if (field.type === 'select' || field.type === 'multiselect') {
                fieldElement.find('[data-repeater-instance]').repeater({
                    initEmpty: false,
                    show: function() {
                        $(this).slideDown();
                    },
                    hide: function(deleteElement) {
                        $(this).slideUp(deleteElement);
                        deleteElement();
                    }
                });
            } else if (field.type === 'repeater') {
                fieldElement.find('.repeater').repeater({
                    initEmpty: !field.fields?.length,
                    defaultValues: {},
                    show: function() {
                        $(this).slideDown();
                    },
                    hide: function(deleteElement) {
                        $(this).slideUp(deleteElement);
                    },
                    isFirstItemUndeletable: false
                });
            }
        }

        removeField(fieldId) {
            this.fields = this.fields.filter(field => field.id !== fieldId);
            $(`.form-field[data-field-id="${fieldId}"]`).remove();
        }

        validateField(fieldElement) {
            const label = fieldElement.find('.field-label').val();
            const name = fieldElement.find('.field-name').val();
            let isValid = true;
            let errors = [];

            if (!label || label.length < 2) {
                isValid = false;
                errors.push('Label is required and must be at least 2 characters');
            }

            if (!name || name.length < 2) {
                isValid = false;
                errors.push('Name is required and must be at least 2 characters');
            }

            if (!/^[a-zA-Z_][a-zA-Z0-9_]*$/.test(name)) {
                isValid = false;
                errors.push(
                    'Name must start with a letter or underscore and contain only letters, numbers, and underscores'
                );
            }

            const nameCount = this.fields.filter(f =>
                f.name === name && f.id !== parseInt(fieldElement.data('field-id'))
            ).length;

            if (nameCount > 0) {
                isValid = false;
                errors.push('Field name must be unique');
            }

            return {
                isValid,
                errors
            };
        }

        saveForm() {
            let isValid = true;
            const errors = [];

            this.fields.forEach(field => {
                const fieldElement = $(`.form-field[data-field-id="${field.id}"]`);
                const validation = this.validateField(fieldElement);

                if (!validation.isValid) {
                    isValid = false;
                    errors.push(...validation.errors);
                }
            });

            if (!isValid) {
                Swal.fire({
                    text: errors.join('\n'),
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'Ok, got it!',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                return;
            }

            const formData = this.fields.map(field => {
                const fieldElement = $(`.form-field[data-field-id="${field.id}"]`);
                const baseData = {
                    type: field.type,
                    label: fieldElement.find('.field-label').val(),
                    name: fieldElement.find('.field-name').val(),
                    required: fieldElement.find('.field-required').is(':checked')
                };

                if (field.type === 'select' || field.type === 'multiselect') {
                    baseData.options = this.getOptionsData(fieldElement);
                } else if (field.type === 'repeater') {
                    baseData.fields = this.getRepeaterFieldsData(fieldElement);
                }

                return baseData;
            });

            $.ajax({
                url: $("#update_structure_url").val(),
                method: 'POST',
                data: {
                    structure: JSON.stringify(formData),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: (response) => {
                    toastr.success(response.message);
                    $('#kt_modal_general').modal('hide');
                },
                error: (error) => {
                    handleAjaxErrors(error);
                }
            });
        }

        getOptionsData(fieldElement) {
            const options = [];
            fieldElement.find('[data-repeater-instance] [data-repeater-item]').each(function() {
                const label = $(this).find('.option-label').val();
                const value = $(this).find('.option-value').val();
                if (label || value) {
                    options.push({
                        label,
                        value
                    });
                }
            });
            return options;
        }


        getRepeaterFieldsData(fieldElement) {
            const fields = [];
            fieldElement.find('[data-repeater-item]').each(function() {
                fields.push({
                    label: $(this).find('input[type="text"]').val(),
                    type: $(this).find('.field-type').val()
                });
            });
            return fields;
        }
    }

    // Initialize Form Generator
    $(document).on('click', '.btn_form_generator_program_page', function(e) {
        e.preventDefault();
        const button = $(this);
        const url = button.attr('href');
        button.attr("data-kt-indicator", "on");

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                const modal = $('#kt_modal_general');
                modal.find('.modal-dialog').html(response.createView);

                const formGenerator = new FormGenerator();
                formGenerator.init($('#form-structure').val());

                new bootstrap.Modal(modal).show();
            },
            error: function(error) {
                handleAjaxErrors(error);
            },
            complete: function() {
                button.removeAttr('data-kt-indicator');
            }
        });
    });
</script>
