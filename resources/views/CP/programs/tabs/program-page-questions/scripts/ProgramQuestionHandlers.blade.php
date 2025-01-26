@php
    $questionTypes = \App\Services\Constants\GetConstantService::get_question_type_list();
@endphp
<script>
    // Pass the question types to JavaScript
    window.questionTypes = @json($questionTypes);
    window.app_locales = @json(config('app.locales'));
</script>
<script>
    // Initialize field type configurations
    window.fieldTypeConfigs = {
        text: {
            showOptions: false,
            showFileProps: false,
            showRepeaterProps: false,
            showTextProps: true,
            showValidation: true
        },
        textarea: {
            showOptions: false,
            showFileProps: false,
            showRepeaterProps: false,
            showTextProps: true,
            showValidation: true
        },
        dropdown: {
            showOptions: true,
            showFileProps: false,
            showRepeaterProps: false,
            showTextProps: false,
            showValidation: true,
            showMultiSelect: true
        },
        checkbox: {
            showOptions: true,
            showFileProps: false,
            showRepeaterProps: false,
            showTextProps: false,
            showValidation: true
        },
        file: {
            showOptions: false,
            showFileProps: true,
            showRepeaterProps: false,
            showTextProps: false,
            showValidation: true
        },
        repeater: {
            showOptions: false,
            showFileProps: false,
            showRepeaterProps: true,
            showTextProps: false,
            showValidation: true
        },
        tags: {
            showOptions: true,
            showFileProps: false,
            showRepeaterProps: false,
            showTextProps: false,
            showValidation: true,
            showTagsProps: true
        }
    };

    // Function to initialize additional fields
    function initializeAdditionalFields() {
        console.log('Starting initializeAdditionalFields');
        const formSelector = '#program_page_question_modal_form';
        const form = $(formSelector);

        const templates = [
            'file-properties-template',
            'repeater-properties-template',
            'text-properties-template',
            'validation-properties-template',
            'tags-properties-template'
        ];

        templates.forEach(templateId => {
            const sectionClass = templateId.replace('-template', '-section');
            if (!form.find('.' + sectionClass).length) {
                const template = document.getElementById(templateId);
                if (template) {
                    form.find('.options-section').after(template.innerHTML);
                }
            }
        });

        // Set initial values if model exists
        if (window._model) {
            if (window._model.file_properties) {
                form.find('[name="file_properties[max_size]"]').val(window._model.file_properties.max_size);
                form.find('[name="file_properties[allowed_extensions]"]').val(window._model.file_properties
                    .allowed_extensions);
                form.find('[name="file_properties[min_files]"]').val(window._model.file_properties.min_files);
                form.find('[name="file_properties[max_files]"]').val(window._model.file_properties.max_files);
            }

            if (window._model.repeater_properties) {
                form.find('[name="repeater_properties[min_items]"]').val(window._model.repeater_properties.min_items);
                form.find('[name="repeater_properties[max_items]"]').val(window._model.repeater_properties.max_items);
            }

            if (window._model.text_properties) {
                form.find('[name="text_properties[min_length]"]').val(window._model.text_properties.min_length);
                form.find('[name="text_properties[max_length]"]').val(window._model.text_properties.max_length);
                form.find('[name="text_properties[pattern]"]').val(window._model.text_properties.pattern);
            }

            if (window._model.tags_properties) {
                form.find('[name="tags_properties[min_tags]"]').val(window._model.tags_properties.min_tags);
                form.find('[name="tags_properties[max_tags]"]').val(window._model.tags_properties.max_tags);
            }
        }
    }

    // Function to handle option addition
    function handleOptionAddition() {
        const formSelector = '#program_page_question_modal_form';

        $(`${formSelector} .add-option`).on('click', function() {
            const optionsContainer = $(formSelector).find('.options-container');
            const newIndex = optionsContainer.children().length;

            const template = document.getElementById('option-row-template');
            if (template) {
                const newRow = template.innerHTML.replace(/__INDEX__/g, newIndex);
                optionsContainer.append(newRow);
            }
        });
    }

    // Function to handle option removal
    function handleOptionRemoval() {
        const formSelector = '#program_page_question_modal_form';

        $(document).on('click', `${formSelector} .remove-option`, function() {
            $(this).closest('.option-row').remove();
        });
    }

    // Function to handle dependent fields
    function handleDependentFields() {
        const formSelector = '#program_page_question_modal_form';

        $(`${formSelector} [name="field_properties[multiple]"]`).on('change', function() {
            const minMaxSelect = $(formSelector).find('.min-max-select-section');
            minMaxSelect.toggle(this.checked);
        });
    }

    // Function to handle type specific logic
    function handleTypeSpecificLogic(type, formSelector) {
        console.log('handleTypeSpecificLogic', type, formSelector);

        $(`${formSelector} .type-specific-field`).hide();

        switch (type) {
            case 'dropdown':
                $(`${formSelector} .multiple-select-option`).show();
                break;
            case 'text':
            case 'textarea':
                $(`${formSelector} .text-pattern-field`).show();
                break;
        }
    }

    // Function to handle field type change
    function handleFieldTypeChange() {
        const formSelector = '#program_page_question_modal_form';

        $(`${formSelector} select[name="field_type_id"]`).on('change', function() {
            const selectedType = $(this).find('option:selected').text().toLowerCase();
            const config = window.fieldTypeConfigs[selectedType] || {
                showOptions: false,
                showFileProps: false,
                showRepeaterProps: false,
                showTextProps: false,
                showValidation: false,
                showTagsProps: false
            };

            // Toggle sections based on field type
            $(`${formSelector} .options-section`).toggle(config.showOptions);
            $(`${formSelector} .file-properties-section`).toggle(config.showFileProps);
            $(`${formSelector} .repeater-properties-section`).toggle(config.showRepeaterProps);
            $(`${formSelector} .text-properties-section`).toggle(config.showTextProps);
            $(`${formSelector} .validation-properties-section`).toggle(config.showValidation);
            $(`${formSelector} .tags-properties-section`).toggle(config.showTagsProps);

            handleTypeSpecificLogic(selectedType, formSelector);
        }).trigger('change');
    }

    // Main initialization function
    function initializeFieldTypeHandlers() {
        console.log('Initializing field type handlers');
        try {
            initializeAdditionalFields();
            handleOptionAddition();
            handleOptionRemoval();
            handleDependentFields();
            handleFieldTypeChange();
            console.log('Field type handlers initialized successfully');
        } catch (error) {
            console.error('Error initializing field type handlers:', error);
        }
    }

    // Make it globally available
    window.initializeFieldTypeHandlers = initializeFieldTypeHandlers;
</script>
