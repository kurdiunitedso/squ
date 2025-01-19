{{-- resources/views/CP/payments/scripts.blade.php --}}
<script>
    "use strict";

    // Class definition
    var KTPayments = function() {
        // Private variables
        var table;
        var recordModal;
        var editModal;
        var validator;

        // Private functions
        var initTable = function() {
            // Initialize datatable
            table = $(document).find('#payment_schedules_table').DataTable({
                responsive: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                ajax: {
                    url: route('payments.data'),
                    type: 'POST',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'sale_id': $('#sale_id').val()
                    }
                },
                columns: [{
                        data: 'payment_type',
                        name: 'payment_type'
                    },
                    {
                        data: 'due_date',
                        name: 'due_date'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'paid_amount',
                        name: 'paid_amount'
                    },
                    {
                        data: 'remaining',
                        name: 'remaining'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        }

        var handleRecordPayment = function() {
            // Initialize form validation
            validator = FormValidation.formValidation(
                document.getElementById('record_payment_form'), {
                    fields: {
                        'payment_date': {
                            validators: {
                                notEmpty: {
                                    message: 'Payment date is required'
                                }
                            }
                        },
                        'amount': {
                            validators: {
                                notEmpty: {
                                    message: 'Amount is required'
                                },
                                numeric: {
                                    message: 'Amount must be a number'
                                },
                                greaterThan: {
                                    message: 'Amount must be greater than 0',
                                    min: 0,
                                }
                            }
                        },
                        'payment_method': {
                            validators: {
                                notEmpty: {
                                    message: 'Payment method is required'
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
                }
            );

            // Handle form submission
            $('#record_payment_form').on('submit', function(e) {
                e.preventDefault();

                if (validator) {
                    validator.validate().then(function(status) {
                        if (status == 'Valid') {
                            submitForm($(e.target));
                        }
                    });
                }
            });
        }

        var submitForm = function(form) {
            // Disable submit button
            const submitButton = form.find('[data-kt-payment-action="submit"]');
            submitButton.attr('data-kt-indicator', 'on');
            submitButton.prop('disabled', true);

            // Submit form
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        toastr.success(response.message);

                        // Close modal
                        $('#record_payment_modal').modal('hide');

                        // Reload table
                        table.ajax.reload();

                        // Update summary cards
                        updateSummaryCards(response.summary);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    // Show error message
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('An error occurred while processing your request.');
                    }
                },
                complete: function() {
                    // Reset submit button
                    submitButton.removeAttr('data-kt-indicator');
                    submitButton.prop('disabled', false);
                }
            });
        }

        var handlePaymentMethod = function() {
            $('#payment_method').on('change', function() {
                const method = $(this).val();
                const bankFields = $('.bank-fields');
                const checkFields = $('.check-fields');

                // Toggle bank fields
                if (method === 'check' || method === 'bank_transfer') {
                    bankFields.removeClass('d-none');
                    if (method === 'check') {
                        checkFields.removeClass('d-none');
                    } else {
                        checkFields.addClass('d-none');
                    }
                } else {
                    bankFields.addClass('d-none');
                    checkFields.addClass('d-none');
                }

                // Update validation rules
                updateValidationRules(method);
            });
        }

        var updateValidationRules = function(paymentMethod) {
            if (paymentMethod === 'check') {
                validator.enableValidator('bank_id');
                validator.enableValidator('check_number');
            } else if (paymentMethod === 'bank_transfer') {
                validator.enableValidator('bank_id');
                validator.disableValidator('check_number');
            } else {
                validator.disableValidator('bank_id');
                validator.disableValidator('check_number');
            }
        }

        var updateSummaryCards = function(summary) {
            $('#total_amount').text(formatCurrency(summary.total_amount));
            $('#paid_amount').text(formatCurrency(summary.paid_amount));
            $('#remaining_amount').text(formatCurrency(summary.remaining_amount));
            $('#next_payment_date').text(summary.next_payment_date || 'N/A');
        }

        var formatCurrency = function(amount) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount);
        }

        // Public methods
        return {
            init: function() {
                initTable();
                handleRecordPayment();
                handlePaymentMethod();
            }
        }
    }();

    // On document ready
    $(document).ready(function() {
        KTPayments.init();
    });
</script>

{{-- Additional script for edit schedule modal --}}
<script>
    $(document).ready(function() {
        // Handle edit schedule modal
        $('#editScheduleModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const scheduleId = button.data('schedule-id');
            const modal = $(this);

            // Get schedule details
            $.get(`/payments/schedules/${scheduleId}`, function(response) {
                if (response.success) {
                    const schedule = response.data;

                    // Fill form fields
                    modal.find('#edit_schedule_id').val(schedule.id);
                    modal.find('#edit_due_date').val(schedule.due_date);
                    modal.find('#edit_amount').val(schedule.amount);
                    modal.find('#edit_bank_id').val(schedule.bank_id).trigger('change');
                    modal.find('#edit_check_number').val(schedule.check_number);
                    modal.find('#edit_notes').val(schedule.notes);

                    // Show paid amount info if any
                    if (schedule.paid_amount > 0) {
                        modal.find('#paid_amount_info').text(
                            `Already paid amount: ${formatCurrency(schedule.paid_amount)}`
                        );
                        modal.find('#edit_amount').attr('min', schedule.paid_amount);
                    }
                }
            });
        });
    });
</script>
