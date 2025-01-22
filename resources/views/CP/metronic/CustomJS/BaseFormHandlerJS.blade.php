<script>
    // Base abstract form handler class
    class BaseFormHandler {
        constructor(options = {}) {
            if (this.constructor === BaseFormHandler) {
                throw new Error("BaseFormHandler is abstract and cannot be instantiated directly.");
            }

            this.form = null;
            this.submitButton = null;
            this.validator = null;
            this.validationManager = null;
        }

        // Template method for initialization flow
        init() {
            try {
                if (!this.findElements()) {
                    return false;
                }
                this.initializeValidation();
                this.initializeDatePickers();
                this.setupSubmitHandler();
                return true;
            } catch (error) {
                console.error('Error initializing FormHandler:', error);
                return false;
            }
        }

        findElements() {
            throw new Error("findElements must be implemented by subclasses");
        }
        // Add this method
        initializeDatePickers() {
            // Initialize past date pickers
            const pastDatePickers = this.form.querySelectorAll('.date-picker-past');
            pastDatePickers.forEach(element => {
                flatpickr(element, {
                    dateFormat: "Y-m-d",
                    maxDate: "today",
                    allowInput: true
                });
            });

            // Initialize future date pickers
            const futureDatePickers = this.form.querySelectorAll('.date-picker-future');
            futureDatePickers.forEach(element => {
                flatpickr(element, {
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    allowInput: true
                });
            });

            // Initialize regular date pickers
            const datePickers = this.form.querySelectorAll(
                '.date-picker:not(.date-picker-past):not(.date-picker-future)');
            datePickers.forEach(element => {
                flatpickr(element, {
                    dateFormat: "Y-m-d",
                    allowInput: true
                });
            });
        }


        initializeValidation() {
            this.validationManager = new FormValidationManager(this.form);
            this.validator = this.validationManager.applyValidationRules();
        }

        setupSubmitHandler() {
            this.submitButton.addEventListener('click', (e) => this.handleSubmit(e));
        }

        async handleSubmit(e) {
            e.preventDefault();

            try {
                if (this.validator) {
                    const status = await this.validator.validate();
                    if (status === 'Valid') {
                        await this.processFormSubmission();
                    } else {
                        this.showValidationError();
                    }
                } else {
                    console.warn('No validator provided, proceeding with submission.');
                    await this.processFormSubmission();
                }
            } catch (error) {
                console.error('Error during form submission:', error);
                this.showSubmissionError();
            }
        }

        async processFormSubmission() {
            throw new Error("processFormSubmission must be implemented by subclasses");
        }

        showValidationError() {
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

        showSubmissionError() {
            Swal.fire({
                text: "An error occurred during form submission. Please try again.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }
    }

    // Regular form handler for non-modal forms
    class RegularFormHandler extends BaseFormHandler {
        constructor(formSelector, submitButtonSelector) {
            super();
            this.formSelector = formSelector;
            this.submitButtonSelector = submitButtonSelector;
        }

        findElements() {
            this.form = document.querySelector(this.formSelector);
            this.submitButton = document.querySelector(this.submitButtonSelector);

            if (!this.form) {
                console.error(`Form not found for selector: ${this.formSelector}`);
                return false;
            }

            if (!this.submitButton) {
                console.error(`Submit button not found for selector: ${this.submitButtonSelector}`);
                return false;
            }

            return true;
        }

        async processFormSubmission() {
            try {
                this.form.submit();
            } catch (error) {
                console.error('Error submitting form:', error);
                this.showSubmissionError();
            }
        }

        static initialize(formSelector, submitButtonSelector) {
            const handler = new RegularFormHandler(formSelector, submitButtonSelector);
            return handler.init();
        }
    }

    // Modal form handler with AJAX submission
    class ModalFormHandler extends BaseFormHandler {
        constructor(options) {
            super();
            this.submitButtonSelector = options.submitButtonSelector;
            this.form = options.form;
            this.modalBootstrap = options.modalBootstrap;
            this.dataTableId = options.dataTableId;
            this.onFormSuccessCallBack = options.onFormSuccessCallBack || this.defaultSuccessCallback.bind(this);
        }

        findElements() {
            this.submitButton = document.querySelector(this.submitButtonSelector);

            if (!this.submitButton) {
                console.error('Submit button not found:', this.submitButtonSelector);
                return false;
            }

            if (!this.form) {
                console.error('Form not provided in options');
                return false;
            }

            return true;
        }

        async processFormSubmission() {
            try {
                this.setSubmitButtonLoading(true);
                const formData = this.prepareFormData();
                const response = await this.submitForm(formData);
                await this.handleSubmissionSuccess(response);
            } catch (error) {
                this.handleSubmissionError(error);
                console.log('call this.handleSubmissionError');

            } finally {
                this.setSubmitButtonLoading(false);
            }
        }

        prepareFormData() {
            const formData = new FormData();

            const attachmentFile = $(this.form).find('input[type="file"]');
            if (attachmentFile.length > 0 && attachmentFile[0].files.length > 0) {
                formData.append('attachment_file', attachmentFile[0].files[0]);
            }

            $.each($(this.form).serializeArray(), function(i, field) {
                formData.append(field.name, field.value);
            });

            return formData;
        }

        async submitForm(formData) {
            return await $.ajax({
                type: 'POST',
                url: $(this.form).attr('action'),
                data: formData,
                contentType: false,
                processData: false
            });
        }

        setSubmitButtonLoading(isLoading) {
            if (isLoading) {
                this.submitButton.setAttribute('data-kt-indicator', 'on');
                this.submitButton.disabled = true;
            } else {
                this.submitButton.removeAttribute('data-kt-indicator');
                this.submitButton.disabled = false;
            }
        }

        async handleSubmissionSuccess(response) {
            await this.onFormSuccessCallBack(
                response,
                this.form,
                this.modalBootstrap,
                this.dataTableId
            );
        }

        handleSubmissionError(error) {
            console.log('call handleAjaxErrors');
            handleAjaxErrors(error);

        }

        defaultSuccessCallback(response, form, modalBootstrap, dataTableId) {
            AttachmentHandler.handleResponse(response);
            toastr.success(response.message);
            form.reset();
            modalBootstrap.hide();
            if (dataTableId) {
                dataTableId.ajax.reload(null, false);
            }
        }

        static initialize(options) {
            const handler = new ModalFormHandler(options);
            return handler.init();
        }
    }
    // ModalRenderer
    class ModalRenderer {
        static async render({
            url,
            button,
            modalId,
            modalBootstrap,
            formId = null,
            dataTableId = null,
            submitButtonName = null,
            onFormSuccessCallBack = null,
            callBackFunction = null
        }) {
            try {
                const response = await $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "json"
                });

                const $modal = $(modalId);
                $modal.find('.modal-dialog').html(response.createView);

                // Initialize modal-specific Flatpickr manager
                let modalFlatpickrManager;

                // Handle modal events
                $modal.on('shown.bs.modal', function() {
                    // Initialize UI components
                    KTScroll.createInstances();
                    KTImageInput.createInstances();

                    if (formId) {
                        const form = document.querySelector(formId);
                        try {
                            if (submitButtonName) {
                                ModalFormHandler.initialize({
                                    submitButtonSelector: submitButtonName,
                                    form: form,
                                    modalBootstrap: modalBootstrap,
                                    dataTableId: dataTableId,
                                    onFormSuccessCallBack: onFormSuccessCallBack
                                });
                            }

                            // Initialize modal-specific Flatpickr
                            modalFlatpickrManager = FlatpickrManager.initialize(form);

                            // Initialize select2 elements
                            ModalRenderer.initializeSelect2Elements(modalId);

                        } catch (error) {
                            console.error('Error initializing form:', error);
                            handleAjaxErrors(error);
                        }
                    }

                    if (callBackFunction && typeof callBackFunction === 'function') {
                        callBackFunction();
                    }
                });

                $modal.on('hidden.bs.modal', function() {
                    if (modalFlatpickrManager) {
                        modalFlatpickrManager.destroy();
                    }
                    $modal.off('shown.bs.modal hidden.bs.modal');
                });

                // Show the modal
                modalBootstrap.show();

            } catch (error) {
                handleAjaxErrors(error);
            } finally {
                if (button) {
                    button.removeAttr('data-kt-indicator');
                }
            }
        }

        static initializeSelect2Elements(modalId) {
            $(modalId).find('[data-control="select2"]').each(function() {
                $(this).select2({
                    dropdownParent: $(modalId),
                    allowClear: true
                });
            });
        }
    }

    // Separate class for handling attachments
    class AttachmentHandler {
        static handleResponse(response) {
            if (!response.attachment) return;

            const attachmentElement = $(document).find(`#${response.attachment.attachment_type_id}`);
            if (attachmentElement.length) {
                attachmentElement
                    .removeClass('d-none')
                    .attr('href', response.attachment.url);
            } else {
                console.warn('Attachment element not found with ID:', response.attachment.attachment_type_id);
            }
        }
    }
</script>
