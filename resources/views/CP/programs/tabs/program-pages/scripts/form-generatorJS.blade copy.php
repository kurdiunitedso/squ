<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
@php
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
            this.initializeSortable();
        }

        initializeEventListeners() {
            document.querySelectorAll('[data-field-type]').forEach(button => {
                button.addEventListener('click', (e) => this.handleFieldTypeClick(e));
            });

            document.getElementById('saveFieldSettings')?.addEventListener('click', () => this.saveFieldSettings());

            document.addEventListener('click', (e) => {
                if (e.target.closest('.edit-field')) {
                    const fieldCard = e.target.closest('.form-field-card');
                    this.editField(fieldCard);
                } else if (e.target.closest('.delete-field')) {
                    const fieldCard = e.target.closest('.form-field-card');
                    this.deleteField(fieldCard);
                }
            });
        }

        initializeSortable() {
            const container = document.querySelector('.form-fields-container');
            new Sortable(container, {
                animation: 150,
                handle: '.drag-handle',
                onEnd: () => this.updateFormStructure()
            });
        }

        handleFieldTypeClick(e) {
            const fieldType = e.target.dataset.fieldType;
            const container = document.querySelector('.form-fields-container');
            this.addField(fieldType, container);
        }

        addField(type, container) {
            const fieldId = 'field_' + Date.now();
            const fieldHtml = `
            <div class="form-field-card mb-3" data-field-id="${fieldId}" data-field-type="${type}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-grip-vertical drag-handle me-2"></i>${type}</div>
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
                    </div>
                </div>
            </div>`;
            container.insertAdjacentHTML('beforeend', fieldHtml);
            this.updateFormStructure();
        }

        editField(fieldCard) {
            this.currentEditingField = fieldCard;
            const modal = new bootstrap.Modal(document.getElementById('fieldSettingsModal'));

            document.getElementById('fieldLabel').value = fieldCard.dataset.label || '';
            document.getElementById('fieldName').value = fieldCard.dataset.name || '';
            document.getElementById('required').checked = fieldCard.dataset.required === 'true';

            modal.show();
        }

        deleteField(fieldCard) {
            if (confirm('Are you sure you want to delete this field?')) {
                fieldCard.remove();
                this.updateFormStructure();
            }
        }

        saveFieldSettings() {
            if (!this.currentEditingField) return;

            const label = document.getElementById('fieldLabel').value;
            const name = document.getElementById('fieldName').value;
            const required = document.getElementById('required').checked;

            this.currentEditingField.dataset.label = label;
            this.currentEditingField.dataset.name = name;
            this.currentEditingField.dataset.required = required;

            const preview = this.currentEditingField.querySelector('.field-preview');
            preview.innerHTML = `<div class="text-muted">Label: ${label}</div>`;

            bootstrap.Modal.getInstance(document.getElementById('fieldSettingsModal')).hide();
            this.updateFormStructure();
        }

        updateFormStructure() {
            this.formStructure = {
                fields: Array.from(document.querySelectorAll('.form-field-card')).map(field => ({
                    id: field.dataset.fieldId,
                    type: field.dataset.fieldType,
                    required: field.dataset.required === 'true',
                    label: field.dataset.label || '',
                    name: field.dataset.name || ''
                }))
            };
            return this.formStructure;
        }
    }

    // Initialize form generator when modal opens
    $(document).on('click', ".btn_form_generator_{{ ProgramPage::ui['s_lcf'] }}", function(e) {
        e.preventDefault();
        const button = $(this);
        button.attr("data-kt-indicator", "on");
        const url = button.attr('href');

        ModalRenderer.render({
            url: url,
            button: button,
            modalId: '#kt_modal_general',
            modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general')),
            formId: '#form_generator_modal_form',
            dataTableId: datatableProgramPage,
            submitButtonName: "[data-kt-modal-action='submit_form_generator']",
            callBackFunction: () => {
                const formBuilder = new FormGenerator();
            }
        });
    });
</script>
