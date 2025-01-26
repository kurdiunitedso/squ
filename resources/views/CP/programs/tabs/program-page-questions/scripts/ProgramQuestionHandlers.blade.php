<script>
    // Add this to pass locales to our JavaScript
    window.app_locales = @json(config('app.locales'));
</script>
<script>
    // Add this to your assets/js/custom/program-questions.js
    const ProgramQuestionHandlers = {
        init: function() {
            this.handleQuestionType();
            this.handleOptions();
            this.handleFormSubmission();
        },

        handleQuestionType: function() {
            // Handle question type change
            $('#question_type').change(function() {
                var type = $(this).val();
                var optionsSection = $('.options-section');

                if (['dropdown', 'checkbox', 'tags'].includes(type)) {
                    optionsSection.show();
                } else {
                    optionsSection.hide();
                }
            });

            // Trigger on load if editing
            $('#question_type').trigger('change');
        },

        handleOptions: function() {
            // Add option
            $('.add-option').click(function() {
                var index = $('.option-row').length;
                let svgIcon = "{{ getSvgIcon('trash') }}";
                var template = `
                <div class="option-row mb-3">
                    <div class="input-group">
                        ${window.app_locales.map(locale => `
                            <input type="text"
                                name="options[${index}][${locale}]"
                                class="form-control form-control-solid"
                                placeholder="${'Option in ' + locale.toUpperCase()}"
                                required>
                        `).join('')}
                        <button type="button" class="btn btn-danger remove-option">
                            ${svgIcon}
                        </button>
                    </div>
                </div>`;
                $('.options-container').append(template);
            });

            // Remove option
            $(document).on('click', '.remove-option', function() {
                $(this).closest('.option-row').remove();
                // Reindex remaining options
                $('.option-row').each(function(index) {
                    $(this).find('input').each(function() {
                        var name = $(this).attr('name');
                        $(this).attr('name', name.replace(/\[\d+\]/, '[' + index +
                            ']'));
                    });
                });
            });
        },

        handleFormSubmission: function() {
            var form = document.querySelector('#program_question_modal_form');
            if (!form) return;

            var submitButton = form.querySelector('[data-kt-modal-action="submit_program_question"]');
            if (!submitButton) return;

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;

                var formData = new FormData(form);

                $.ajax({
                    url: form.action,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                text: response.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "{{ t('Ok, got it!') }}",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function() {
                                $('#kt_modal_general').modal('hide');
                                if (typeof datatableProgramPageQuestion !==
                                    'undefined') {
                                    datatableProgramPageQuestion.ajax.reload();
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';

                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '\n';
                        });

                        Swal.fire({
                            text: errorMessage || xhr.responseJSON.message,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "{{ t('Ok, got it!') }}",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    },
                    complete: function() {
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;
                    }
                });
            });
        }
    };
</script>
