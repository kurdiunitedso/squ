<script>
    const baseUrl = "{{ asset('') }}";

    function initializeFlatpickr(form = null) {
        initFlatpickr('.date-flatpickr-dob-24', {
            maxDate: "today",
        });
        initFlatpickr('.date-flatpickr-min-today', {
            minDate: "today",
        });
        // Initialize time pickers with the class 'time-flatpickr' using the reusable initFlatpickr function
        initFlatpickr('.time-flatpickr', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

    }

    // Reusable function to initialize flatpickr with default options
    function initFlatpickr(selector, options = {}) {
        // console.log('initFlatpickr called for selector:', selector);
        return $(selector).flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
            allowInput: true,
            ...options
        });
    }

    $(function() {
        // console.log('Document ready, initializing date and time pickers');
        initializeFlatpickr();
    });
</script>
<script>
    // Enhanced AJAX error handler with UI update support
    const handleAjaxErrors = function(xhr, status, error, options = {}) {
        console.error('Ajax request failed. Status:', xhr.status, 'Error:', error);

        // Extract options with defaults
        const {
            elementToReset = null, // Element to reset opacity/state
                originalContainer = null, // Original container for reverting drag
                draggedElement = null, // Element that was dragged
                submitButton = null, // Submit button to reset
                onValidationError = null, // Custom validation error handler
                afterErrorHandle = null // Callback after error handling
        } = options;

        // Handle different error statuses
        if (xhr.status === 401 || xhr.status === 419) {
            let currentUrl = window.location.href;
            console.error('User is unauthenticated or session expired. Redirecting to login.', {
                status: xhr.status,
                error: error
            });
            toastr.error('Session expired or unauthenticated. Redirecting to login.');
            window.location.href = "{{ route('login') }}?redirect=" + encodeURIComponent(currentUrl);
            return;
        }

        if (xhr.status === 422) {
            console.error('Validation error received:', xhr.responseJSON.errors);
            toastr.error('There was a validation error. Please check your inputs and try again.');

            // Clear previous validation errors
            $('.validation-error').remove();

            let errors = xhr.responseJSON.errors;
            console.log('Processing validation errors:', errors);

            // Process validation errors
            for (const [field, messages] of Object.entries(errors)) {
                let fieldName = field.replace(/\.(\w+)/g, '[$1]');
                let fieldElement = $(`[name="${fieldName}"]`);

                if (fieldElement.length > 0) {
                    fieldElement.after(`<span class="validation-error text-danger">${messages[0]}</span>`);
                }
            }

            // Call custom validation error handler if provided
            if (onValidationError && typeof onValidationError === 'function') {
                onValidationError(errors);
            }
        } else if (xhr.status === 500) {
            console.error('Internal server error occurred.', {
                status: xhr.status,
                error: error
            });
            toastr.error('A server error occurred. Please try again later.');
        } else if (xhr.status === 400) {
            toastr.warning(xhr.responseJSON.message);
        } else {
            console.error('An unexpected error occurred.', {
                status: xhr.status,
                error: error
            });
            toastr.error('An unexpected error occurred. Please try again.');
        }

        // Reset element opacity if provided
        if (elementToReset) {
            elementToReset.style.opacity = '1';
        }

        // Revert dragged element if provided
        if (originalContainer && draggedElement) {
            originalContainer.appendChild(draggedElement);
        }

        // Reset submit button if provided
        if (submitButton) {
            submitButton.attr('data-kt-indicator', 'off');
            submitButton.prop('disabled', false);
        } else {
            // Legacy support for existing code
            var subBtn = $('button[data-kt-indicator="on"]');
            if (subBtn.length) {
                subBtn.attr('data-kt-indicator', 'off');
                subBtn.prop('disabled', false);
            }
        }

        // Execute after error callback if provided
        if (afterErrorHandle && typeof afterErrorHandle === 'function') {
            afterErrorHandle(xhr, status, error);
        }
    };

    // Updated task board code using the enhanced error handler
    function updateTaskAndRecordProcess(taskId, newStatusId, oldStatusId, cardElement) {
        // Show loading state
        cardElement.style.opacity = '0.5';

        $.ajax({
            url: taskUpdateUrl,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                task_id: taskId,
                new_status_id: newStatusId,
                old_status_id: oldStatusId
            },
            success: function(response) {
                if (response.success) {
                    cardElement.style.opacity = '1';

                    Swal.fire({
                        text: response.message || 'Task moved successfully!',
                        icon: 'success',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok, got it!',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });

                    // Update task UI if needed
                    if (response.task) {
                        updateTaskUI(cardElement, response.task);
                    }
                } else {
                    handleMoveError(cardElement, oldStatusId, response.message);
                }
            },
            error: function(xhr, status, error) {
                // Use the enhanced error handler with task-specific options
                handleAjaxErrors(xhr, status, error, {
                    elementToReset: cardElement,
                    originalContainer: document.getElementById(oldStatusId),
                    draggedElement: cardElement,
                    afterErrorHandle: function() {
                        // Additional task-specific error handling if needed
                        cardElement.querySelector('.card-status').textContent = 'Status: Error';
                    }
                });
            }
        });
    }

    // Example usage in another blade (e.g., form submission)
    function submitForm(formElement) {
        const submitBtn = $(formElement).find('button[type="submit"]');
        submitBtn.attr('data-kt-indicator', 'on');
        submitBtn.prop('disabled', true);

        $.ajax({
            url: formElement.action,
            method: 'POST',
            data: new FormData(formElement),
            processData: false,
            contentType: false,
            success: function(response) {
                // Handle success
            },
            error: function(xhr, status, error) {
                handleAjaxErrors(xhr, status, error, {
                    submitButton: submitBtn,
                    onValidationError: function(errors) {
                        // Form-specific validation handling
                        highlightFormErrors(formElement, errors);
                    }
                });
            }
        });
    }

    // Helper function for form error highlighting
    function highlightFormErrors(form, errors) {
        // Form-specific error highlighting logic
        // This can be customized per form/blade
    }
</script>

<script>
    function setField(fieldName, value) {
        const $field = $(`[name="${fieldName}"]`);
        const oldValue = "{{ old('" + fieldName + "') }}";
        $field.val(oldValue || value);
        console.log(`Set ${fieldName}: ${$field.val()}`);
    }

    function setSelectField(fieldName, value) {
        const $field = $(`[name="${fieldName}"]`);
        const oldValue = "{{ old('" + fieldName + "') }}";
        $field.val(oldValue || value).trigger('change');
        console.log(`Set ${fieldName} (select): ${$field.val()}`);
    }

    function setActiveStatus(isActive) {
        const $activeCheckbox = $('#active');
        $activeCheckbox.prop('checked', isActive === 1);
        console.log(`Set active status: ${isActive === 1}`);
    }
</script>

<script>
    function getSelect2(model, selector, placeholder = 'Select an option', callback = null, parent_id = null) {
        // console.log('Initializing Select2 for selector:', selector);
        // console.log('Model:', model);
        // console.log('Placeholder:', placeholder);
        // console.log('Parent ID:', parent_id);
        // console.log('Callback provided:', callback !== null);

        $(selector).select2({
            placeholder: placeholder,
            allowClear: true,
            ajax: {
                url: "{{ route('getSelect2') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    // console.log('AJAX request parameters:', params);
                    return {
                        q: params.term,
                        page: params.page || 1,
                        model: model,
                        parent_id: parent_id,
                    };
                },
                processResults: function(data, params) {
                    // console.log('Received data from server:', data);
                    // console.log('Current page:', params.page);
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    };
                },
                cache: true,
                error: handleAjaxErrors,
            },
            minimumInputLength: 1,
            templateResult: formatItem,
            templateSelection: formatItemSelection
        });

        if (callback) {
            $(selector).on('select2:select', function(e) {
                let selectedId = $(this).val();
                // console.log('Item selected with ID:', selectedId);
                callback(selectedId, model);
            });
        }

        function formatItem(item) {
            // console.log('Formatting item:', item);

            if (item.loading) {
                // console.log('Item is loading');
                return item.text;
            }

            let $container = $(
                "<div class='select2-result-item clearfix'>" +
                "<div class='select2-result-item__meta'>" +
                "<div class='select2-result-item__title'></div>" +
                "</div>" +
                "</div>"
            );

            $container.find(".select2-result-item__title").text(item.name);
            // console.log('Formatted item container:', $container);
            return $container;
        }

        function formatItemSelection(item) {
            // console.log('Formatting item selection:', item);
            return item.name || item.text;
        }
    }
</script>


<script>
    function globalRenderModal(url, button, modalId, modalBootstrap, validatorFields = {}, formId = null,
        dataTableId = null, submitButtonName = null, RequiredInputList = {}, onFormSuccessCallBack = null,
        fillSelectListFromAjaxData = null, callBackFunction = null) {
        // console.log('Step 1: Starting globalRenderModal');
        // console.log('URL:', url);
        // console.log('Button:', button);
        // console.log('Modal ID:', modalId);
        // console.log('Modal Bootstrap Instance:', modalBootstrap);
        // console.log('Validator Fields:', validatorFields);
        // console.log('Form ID:', formId);
        console.log('callBackFunction:', callBackFunction);
        // console.log('DataTable ID:', dataTableId);
        // console.log('Submit Button Name:', submitButtonName);
        // console.log('Required Input List:', RequiredInputList);
        // console.log('fillSelectListFromAjaxData:', fillSelectListFromAjaxData);

        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function(response) {
                // console.log('Step 2: AJAX Success');
                // console.log('Response:', response);
                $(modalId).find('.modal-dialog').html(response.createView);
                modalBootstrap.show();
                // console.log('Step 3: Modal shown');
                KTScroll.createInstances();
                KTImageInput.createInstances();
                // console.log('Step 4: KTScroll and KTImageInput instances created');
                if (formId) {
                    const form = document.querySelector(formId);
                    // console.log('Form selector:', formId, 'Form found:', form);
                    // console.log('Validator fields provided:', validatorFields);
                    try {
                        // if (validatorFields == null) {
                        //     validatorFields = [];
                        // }
                        var validator = FormValidation.formValidation(
                            form, {
                                fields: validatorFields,
                                plugins: {
                                    trigger: new FormValidation.plugins.Trigger(),
                                    bootstrap: new FormValidation.plugins.Bootstrap5({
                                        rowSelector: '.fv-row',
                                        eleInvalidClass: '',
                                        eleValidClass: ''
                                    })
                                }
                            }
                        );
                        // console.log('Step 5: Form validation initialized');
                    } catch (error) {
                        console.error('Error initializing form validation:', error);
                    }
                    initializeFlatpickr(form);
                    // console.log('Step 6: Flatpickr initialized');

                    applyValidationRules(form, validator);
                    if (submitButtonName) {
                        initializeSubmitButton(submitButtonName, form, validator, onFormSuccessCallBack,
                            modalBootstrap, dataTableId);
                        // console.log('Step 8: Submit button initialized');
                    }
                }
                if (callBackFunction) {
                    console.log('Running callback function');
                    callBackFunction
                        (); // Here accitanceCompany() in insurance companies services will be called
                } else {
                    console.log('global render => No callback function');
                }


                // Initialize select2 if elements exist
                initializeSelect2(modalId);

                // Fill select list from AJAX if data is provided
                if (fillSelectListFromAjaxData) {
                    fillSelectListFromAjax(fillSelectListFromAjaxData);
                    $(fillSelectListFromAjaxData.parentSelect).on('change', function() {
                        fillSelectListFromAjax(fillSelectListFromAjaxData);
                    });
                }

            },
            complete: function() {
                if (button) {
                    button.removeAttr('data-kt-indicator');
                }
            },
            error: handleAjaxErrors,
        });
    }

    // Function to initialize select2 for dropdowns
    function initializeSelect2(modalId) {
        // console.log('Initializing select2 elements inside modal:', modalId);

        // Initialize select2 for elements with the [data-control="select2"] attribute
        $(modalId).find('[data-control="select2"]').each(function() {
            $(this).select2({
                dropdownParent: $(modalId),
                allowClear: true
            });
            // console.log('select2 initialized for:', this);
        });
    }

    function fillSelectListFromAjax(fillSelectListFromAjaxData) {
        // console.log('fillSelectListFromAjax called with:', fillSelectListFromAjaxData);
        const parentSelect = $(fillSelectListFromAjaxData.parentSelect);
        const parentSelectId = parentSelect.val();
        const chiledSelect = $(fillSelectListFromAjaxData.chiledSelect);
        const selectedChildId = fillSelectListFromAjaxData.selectedChildId;
        const route = fillSelectListFromAjaxData.route.replace('__ID__', parentSelectId);
        // console.log('parentSelect', parentSelect);
        // console.log('parentSelectId', parentSelectId);
        // console.log('chiledSelect', chiledSelect);
        // console.log('selectedChildId', selectedChildId);
        // console.log('route', route);

        if (parentSelectId) {
            $.ajax({
                url: route,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // console.log('fillSelectListFromAjax Success with data:', data);
                    chiledSelect.empty().append(
                        '<option></option>'); // Clear existing options and add a placeholder

                    $.each(data, function(key, value) {
                        chiledSelect.append('<option value="' + value.id + '">' + value
                            .current_local_name +
                            '</option>');
                    });

                    if (selectedChildId) {
                        chiledSelect.val(selectedChildId).trigger('change');
                    }
                },
                error: handleAjaxErrors,
            });
        } else {
            chiledSelect.empty().append('<option></option>'); // Clear options if no parent is selected
        }
    }

    function initializeFlatpickr(form = null) {
        initFlatpickr('.date-flatpickr-dob-24', {
            maxDate: "today",
        });
        initFlatpickr('.date-flatpickr-min-today', {
            minDate: "today",
        });
        // Initialize time pickers with the class 'time-flatpickr' using the reusable initFlatpickr function
        initFlatpickr('.time-flatpickr', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

    }

    // Reusable function to initialize flatpickr with default options
    function initFlatpickr(selector, options = {}) {
        // console.log('initFlatpickr called for selector:', selector);
        return $(selector).flatpickr({
            enableTime: false,
            dateFormat: "Y-m-d",
            allowInput: true,
            ...options
        });
    }

    $(function() {
        // console.log('Document ready, initializing date and time pickers');
        initializeFlatpickr();
    });



    function initializeSubmitButton(submitButtonName, form, validator, onFormSuccessCallBack, modalBootstrap,
        dataTableId) {
        const submitButton = document.querySelector(submitButtonName);
        if (!submitButton) {
            console.error('Submit button not found:', submitButtonName);
            return;
        }
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            if (validator) {
                validator.validate().then(function(status) {
                    if (status === 'Valid') {
                        handleFormSubmission(form, submitButton, onFormSuccessCallBack, modalBootstrap,
                            dataTableId);
                    } else {
                        console.warn('Form validation failed, showing error alert.');
                        showValidationErrorAlert();
                    }
                }).catch(function(error) {
                    console.error('Error during form validation:', error);
                });
            } else {
                console.warn('No validator provided, skipping form validation.');
                handleFormSubmission(form, submitButton, onFormSuccessCallBack, modalBootstrap, dataTableId);
            }
        });

        // console.log('Click event listener added to submit button:', submitButtonName);
    }

    // This is for policy offer module
    function handleAttachmentsResponse(response) {
        // Check if the response contains an attachment
        if (response.attachment) {
            // Find the element by the attachment_type_id
            var attachmentElement = $(document).find('#' + response.attachment.attachment_type_id);

            // Check if the element exists before manipulating it
            if (attachmentElement.length) {
                // Remove 'd-none' class if the element exists
                attachmentElement.removeClass('d-none');

                // Set the 'href' attribute with the URL if the element exists
                attachmentElement.attr('href', response.attachment.url);
            } else {
                console.warn('Attachment element not found with ID:', response.attachment.attachment_type_id);
            }
        }
    }


    function handleFormSubmission(form, submitButton, onFormSuccessCallBack, modalBootstrap, dataTableId) {
        if (!onFormSuccessCallBack) {
            onFormSuccessCallBack = function(response, form, modalBootstrap, dataTableId) {
                handleAttachmentsResponse(response);
                toastr.success(response.message);
                form.reset();
                modalBootstrap.hide();
                if (dataTableId) {
                    dataTableId.ajax.reload(null, false);
                }
            };
        }
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
        var attachment_file = $(form).find('input[type="file"]');
        var formData = new FormData();
        if (attachment_file.length > 0 && attachment_file[0].files.length > 0) {
            formData.append('attachment_file', attachment_file[0].files[0]);
            // console.log('File appended to FormData:', attachment_file[0].files[0]);
        } else {
            // console.log('No file selected or file input not found.');
        }
        $.each($(form).serializeArray(), function(i, field) {
            formData.append(field.name, field.value);
            // console.log(`Serialized form field: ${field.name} = ${field.value}`);
        });
        $.ajax({
            type: 'POST',
            url: $(form).attr('action'),
            data: formData,
            contentType: false, // Important: Prevent jQuery from setting Content-Type header
            processData: false, // Important: Prevent jQuery from processing the data

            success: function(response) {
                // console.log('AJAX success callback triggered.');
                // onFormSuccessCallBack(response);
                onFormSuccessCallBack(response, form, modalBootstrap, dataTableId)

            },
            complete: function() {
                // console.log('Form submission completed, resetting submit button.');
                submitButton.removeAttribute('data-kt-indicator');
                submitButton.disabled = false;
            },
            error: handleAjaxErrors,
        });
    }


    function showValidationErrorAlert() {
        // console.log('Showing form validation error alert.');
        Swal.fire({
            text: "Sorry, looks like there are some errors detected, please try again.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    }

    function applyValidationRules(form, validator) {
        console.log('Starting validation rules application for form:', form);

        $(form).find('input, select, textarea').each(function() {
            const field = $(this);
            const fieldName = field.attr('name');
            const fieldType = field.attr('type');

            // Skip hidden fields and special inputs
            if (fieldType === 'hidden' || fieldName === '_token') {
                console.log(`Skipping hidden/special field: ${fieldName}`);
                return;
            }

            console.log('Processing field:', fieldName);

            if (fieldName) {
                let validators = {};

                // Check for required validation
                if (field.hasClass('validate-required')) {
                    console.log(`${fieldName}: Adding required validation`);
                    validators.notEmpty = {
                        message: `${field.closest('div').find('label').text().trim()} is required`,
                    };
                }

                // Check for number validation
                if (field.hasClass('validate-number')) {
                    console.log(`${fieldName}: Adding number validation`);
                    validators.numeric = {
                        message: 'The value must be a valid number',
                        decimalSeparator: '.',
                    };
                }

                // Dynamic min/max value validation
                const classes = field.attr('class');
                if (classes) { // Check if classes exist
                    const classList = classes.split(' ');
                    console.log(`${fieldName}: Checking classes:`, classList);

                    for (let className of classList) {
                        // Min validation
                        if (className.startsWith('validate-min-')) {
                            const minValue = parseInt(className.replace('validate-min-', ''));
                            if (!isNaN(minValue)) {
                                console.log(`${fieldName}: Adding min validation for value:`, minValue);
                                validators.greaterThan = {
                                    message: `The value must be greater than or equal to ${minValue}`,
                                    min: minValue,
                                    inclusive: true
                                };
                            }
                        }

                        // Max validation
                        if (className.startsWith('validate-max-')) {
                            const maxValue = parseInt(className.replace('validate-max-', ''));
                            if (!isNaN(maxValue)) {
                                console.log(`${fieldName}: Adding max validation for value:`, maxValue);
                                validators.lessThan = {
                                    message: `The value must be less than or equal to ${maxValue}`,
                                    max: maxValue,
                                    inclusive: true
                                };
                            }
                        }
                    }
                }

                // Check for email validation
                if (field.hasClass('validate-email')) {
                    console.log(`${fieldName}: Adding email validation`);
                    validators.emailAddress = {
                        message: 'The value must be a valid email address',
                    };
                }

                // Add the field and its validators if there are any rules
                if (Object.keys(validators).length > 0) {
                    console.log(`${fieldName}: Applying validators:`, validators);
                    validator.addField(fieldName, {
                        validators: validators
                    });
                } else {
                    console.log(`${fieldName}: No validators applied`);
                }
            } else {
                console.log('Skipping field with no name attribute');
            }
        });

        console.log('Completed validation rules application');
    }
</script>

<script>
    let currentValidator = null;

    function renderValidate(formSelector, submitButtonSelector) {
        const form = document.querySelector(formSelector);
        if (!form) {
            console.error(`Form not found for selector: ${formSelector}`);
            return;
        }

        // Safely destroy previous validator
        try {
            if (currentValidator) {
                // Remove validation messages first
                $(form).find('.fv-plugins-message-container').remove();

                // Clear existing fields
                if (currentValidator.fields) {
                    Object.keys(currentValidator.fields).forEach(field => {
                        currentValidator.removeField(field);
                    });
                }

                // Then destroy
                currentValidator.destroy();
                currentValidator = null;
            }
        } catch (error) {
            console.warn('Error cleaning up previous validator:', error);
            // Continue with new validator creation
        }

        // Initialize new validator
        try {
            currentValidator = FormValidation.formValidation(
                form, {
                    fields: {},
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );

            // Apply validation rules
            applyValidationRules(form, currentValidator);

            // Get the submit button
            const submitButton = document.querySelector(submitButtonSelector);
            if (!submitButton) {
                console.error(`Submit button not found for selector: ${submitButtonSelector}`);
                return;
            }

            // Remove any existing click handlers
            const newSubmitButton = submitButton.cloneNode(true);
            submitButton.parentNode.replaceChild(newSubmitButton, submitButton);

            // Add new click handler
            newSubmitButton.addEventListener('click', function(e) {
                e.preventDefault();

                if (currentValidator) {
                    currentValidator.validate().then(function(status) {
                        if (status === 'Valid') {
                            form.submit();
                        } else {
                            Swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });
                }
            });

        } catch (error) {
            console.error('Error creating new validator:', error);
        }
    }
</script>

<script>
    // Function to determine text color based on background color
    function getContrastYIQ(hexcolor) {
        if (!hexcolor) return 'black'; // Default to black if no color is provided
        hexcolor = hexcolor.replace("#", "");
        if (hexcolor.length !== 6) return 'black'; // Default to black if invalid hex
        var r = parseInt(hexcolor.substr(0, 2), 16);
        var g = parseInt(hexcolor.substr(2, 2), 16);
        var b = parseInt(hexcolor.substr(4, 2), 16);
        var yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;
        return (yiq >= 128) ? 'black' : 'white';
    }
</script>

{{-- initializeObjectivesSelect --}}
<script>
    // Maintain references to initialized selects
    const initializedSelects = new Map();

    function initializeObjectivesSelect(selector, options = {}) {
        // Check if already initialized
        if (initializedSelects.has(selector)) {
            return initializedSelects.get(selector);
        }

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        function createAndSaveTag($select, term) {
            if (!term || term.length < 2) return;

            // Get the currently selected objective type
            const selectedObjectiveType = $('[name="objective_type_id"]').val();
            if (!selectedObjectiveType) {
                toastr.error('Please select an objective type first');
                return;
            }

            const newTag = {
                id: term,
                text: term,
                isNew: true
            };

            // Create and select the new option
            const $option = new Option(newTag.text, newTag.id, true, true);
            $select.append($option).trigger('change');

            const $tag = $select.next().find(`.select2-selection__choice:contains('${term}')`);

            // Add loading state
            $tag.addClass('loading');
            $tag.css('opacity', '0.7');

            $.ajax({
                url: "{{ route('store-objective') }}",
                method: 'POST',
                data: {
                    name: term,
                    objective_type_id: selectedObjectiveType,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.success('New objective added successfully');
                    $($option).data('saved', true);
                    $tag.removeClass('loading').css('opacity', '1');
                },
                error: function(xhr) {
                    $option.remove();
                    $select.trigger('change');

                    if (xhr.status === 422) {
                        toastr.error(xhr.responseJSON.errors.name[0]);
                    } else {
                        toastr.error('Failed to add objective');
                    }
                }
            });
        }

        const defaultOptions = {
            tags: true,
            tokenSeparators: [','],
            placeholder: "Type to add objectives...",
            allowClear: true,
            minimumInputLength: 0,
            maximumInputLength: 100,
            maximumSelectionLength: 10,
            selectOnClose: false,
            dropdownParent: options.dropdownParent || $('body'),
            language: {
                inputTooShort: function() {
                    return "Type to search objectives...";
                },
                searching: function() {
                    return "Searching...";
                },
                noResults: function() {
                    const selectedObjectiveType = $('[name="objective_type_id"]').val();
                    return selectedObjectiveType ? "Press Enter or Tab to add as new objective" :
                        "Please select an objective type first";
                },
                loadingMore: function() {
                    return "Loading more results...";
                }
            },
            createTag: function(params) {
                const selectedObjectiveType = $('[name="objective_type_id"]').val();
                return selectedObjectiveType ? {
                    id: params.term,
                    text: params.term
                } : null;
            },
            // Update the ajax configuration in defaultOptions
            ajax: {
                url: "{{ route('get-objectives') }}",
                dataType: 'json',
                delay: 250,
                transport: debounce(function(params, success, failure) {
                    const selectedObjectiveType = $('[name="objective_type_id"]').val();
                    if (!selectedObjectiveType) {
                        success({
                            results: [],
                            pagination: {
                                more: false
                            }
                        });
                        return null;
                    }
                    const $request = $.ajax(params);
                    return $request.then(success).fail(failure);
                }, 250),
                data: function(params) {
                    return {
                        q: params.term || '',
                        page: params.page || 1,
                        objective_type_id: $('[name="objective_type_id"]').val()
                    };
                },
                processResults: function(response, params) {
                    params.page = params.page || 1;

                    // Check if response has the expected structure
                    if (!response || typeof response !== 'object') {
                        console.error('Invalid response format:', response);
                        return {
                            results: [],
                            pagination: {
                                more: false
                            }
                        };
                    }

                    // Get the data array from the response, handling both possible structures
                    const data = response.data || response || [];

                    // Ensure data is an array
                    const dataArray = Array.isArray(data) ? data : [];

                    try {
                        const processedData = dataArray.map(item => ({
                            id: item.name || item.id || '',
                            text: item.name || item.text || '',
                            isExisting: true
                        }));

                        return {
                            results: processedData,
                            pagination: {
                                more: response.pagination ? response.pagination.more : false
                            }
                        };
                    } catch (error) {
                        console.error('Error processing results:', error);
                        return {
                            results: [],
                            pagination: {
                                more: false
                            }
                        };
                    }
                },
                cache: true
            }
        };

        const finalOptions = {
            ...defaultOptions,
            ...options
        };
        const $select = $(selector).select2(finalOptions);

        // Store reference
        initializedSelects.set(selector, $select);

        // Handle keydown events for Enter and Tab
        $select.on('select2:open', function() {
            const $search = $(finalOptions.dropdownParent).find('.select2-search__field').last();

            $search.off('keydown').on('keydown', function(e) {
                const term = $.trim($search.val());

                if ((e.keyCode === 13 || e.keyCode === 9) && term) {
                    e.preventDefault();
                    e.stopPropagation();
                    createAndSaveTag($select, term);
                    $search.val('').trigger('input');
                }
            });
        });
        // Handle objective type change
        $('[name="objective_type_id"]').on('change', function() {
            const selectedType = $(this).val();
            const $objectivesSelect = $('#objectives-select');
            const modelClass = $(this).data('model-class');
            const modelId = $(this).data('model-id');

            // Clear existing selections
            $select.val(null).trigger('change');

            // Fetch objectives for the selected type and model
            if (selectedType) {

                console.log({
                    objective_type_id: selectedType,
                    model_class: modelClass,
                    model_id: modelId
                }, );

                $.ajax({
                    url: "{{ route('get-objectives') }}",
                    data: {
                        objective_type_id: selectedType,
                        model_class: modelClass,
                        model_id: modelId
                    },
                    success: function(response) {
                        if (response.status && response.data) {
                            // Clear and update the objectives select
                            $select.empty();

                            response.data.forEach(function(objective) {
                                const option = new Option(objective.name, objective.name,
                                    false, true);
                                $select.append(option);
                            });

                            $select.trigger('change');
                        }
                    },
                    error: function() {
                        toastr.error('Failed to fetch objectives');
                    }
                });
            }
        });

        return $select;
    }

    // Function to destroy select2 instance
    function destroyObjectivesSelect(selector) {
        if (initializedSelects.has(selector)) {
            const $select = initializedSelects.get(selector);
            $select.select2('destroy');
            initializedSelects.delete(selector);
        }
    }

    // Initialize modal objectives
    function initializeModalObjectives() {
        try {
            destroyObjectivesSelect('#kt_modal_general .objectives-select');

            const modalObjectivesSelect = initializeObjectivesSelect('#kt_modal_general .objectives-select', {
                dropdownParent: $('#kt_modal_general')
            });

            $('#kt_modal_general').one('hidden.bs.modal', function() {
                destroyObjectivesSelect('#kt_modal_general .objectives-select');
            });
        } catch (error) {
            console.error('Failed to initialize modal objectives:', error);
            toastr.error('Failed to initialize objectives selector');
        }
    }



    // Debug event listeners
    $(document).on('select2:opening', '.objectives-select, #objectives-select', function(e) {
        const id = $(this).attr('id') || 'modal select';
        console.debug('Select2 dropdown opening for:', id);
    });

    $(document).on('select2:select', '.objectives-select, #objectives-select', function(e) {
        const id = $(this).attr('id') || 'modal select';
        console.debug('New objective selected for:', id, e.params.data);
    });

    $(document).on('select2:close', '.objectives-select, #objectives-select', function(e) {
        const id = $(this).attr('id') || 'modal select';
        console.debug('Select2 dropdown closed for:', id);
        console.debug('Current objectives:', $(this).val());
    });
</script>
