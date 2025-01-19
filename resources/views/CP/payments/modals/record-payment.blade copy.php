{{-- resources/views/CP/payments/modals/record-payment.blade.php --}}
<div class="modal fade" id="recordPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="recordPaymentForm" action="" method="POST">
                @csrf
                <input type="hidden" id="schedule_id" name="schedule_id">

                <div class="modal-header">
                    <h2 class="fw-bold">Record Payment</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>

                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    {{-- Payment Date --}}
                    <div class="row mb-5">
                        <div class="col">
                            <label class="required form-label">Payment Date</label>
                            <input type="date" class="form-control" name="payment_date" required
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    {{-- Amount --}}
                    <div class="row mb-5">
                        <div class="col">
                            <label class="required form-label">Payment Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" name="amount" id="payment_amount" required
                                    step="0.01" min="0.01">
                            </div>
                            <div class="form-text">Maximum amount cannot exceed the remaining balance</div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="row mb-5">
                        <div class="col">
                            <label class="required form-label">Payment Method</label>
                            <select class="form-select" name="payment_method" id="payment_method" required>
                                <option value="cash">Cash</option>
                                <option value="check">Check</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="credit_card">Credit Card</option>
                            </select>
                        </div>
                    </div>

                    {{-- Bank Fields (shown for check/bank transfer) --}}
                    <div class="bank-fields" style="display: none;">
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label class="required form-label">Bank</label>
                                <select class="form-select" name="bank_id" data-control="select2"
                                    data-placeholder="Select Bank">
                                    <option></option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Branch</label>
                                <input type="text" class="form-control" name="bank_branch">
                            </div>
                        </div>

                        {{-- Check Fields --}}
                        <div class="check-fields row mb-5" style="display: none;">
                            <div class="col-md-6">
                                <label class="required form-label">Check Number</label>
                                <input type="text" class="form-control" name="check_number">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Check Date</label>
                                <input type="date" class="form-control" name="check_date">
                            </div>
                        </div>
                    </div>

                    {{-- Reference Number --}}
                    <div class="row mb-5">
                        <div class="col">
                            <label class="form-label">Reference Number</label>
                            <input type="text" class="form-control" name="reference_number"
                                placeholder="Transaction/Receipt number">
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="row mb-5">
                        <div class="col">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitPayment">
                        <span class="indicator-label">
                            Record Payment
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        "use strict";

        // Class definition
        var KTRecordPayment = function() {
            var submitButton;
            var form;
            var validator;

            // Init form inputs
            var initForm = function() {
                // Due date - initialize flatpickr
                $(form.querySelector('[name="payment_date"]')).flatpickr({
                    enableTime: false,
                    dateFormat: "Y-m-d",
                });

                // Format currency input
                $(form.querySelector('[name="amount"]')).on('input', function(e) {
                    if (this.value.length > 0) {
                        this.value = parseFloat(this.value).toFixed(2);
                    }
                });

                // Initialize select2 for bank selection
                $(form.querySelector('[name="bank_id"]')).select2({
                    minimumResultsForSearch: 10
                });
            }

            // Handle form validation and submission
            var handleForm = function() {
                validator = FormValidation.formValidation(
                    form, {
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
                                        message: 'Payment amount is required'
                                    },
                                    numeric: {
                                        message: 'Amount must be a valid number',
                                        thousandsSeparator: '',
                                        decimalSeparator: '.'
                                    },
                                    between: {
                                        min: 0.01,
                                        max: 999999999,
                                        message: 'Amount must be greater than 0'
                                    }
                                }
                            },
                            'payment_method': {
                                validators: {
                                    notEmpty: {
                                        message: 'Payment method is required'
                                    }
                                }
                            },
                            'bank_id': {
                                validators: {
                                    notEmpty: {
                                        message: 'Bank is required',
                                        enabled: false
                                    }
                                }
                            },
                            'check_number': {
                                validators: {
                                    notEmpty: {
                                        message: 'Check number is required',
                                        enabled: false
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.row',
                                eleInvalidClass: '',
                                eleValidClass: ''
                            })
                        }
                    }
                );

                // Handle form submit
                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    validator.validate().then(function(status) {
                        if (status === 'Valid') {
                            submitButton.setAttribute('data-kt-indicator', 'on');
                            submitButton.disabled = true;

                            // Get schedule ID and set form action
                            const scheduleId = form.querySelector('#schedule_id').value;
                            form.action = `/payments/schedules/${scheduleId}/record`;

                            // Submit form
                            $.ajax({
                                url: form.action,
                                method: 'POST',
                                data: $(form).serialize(),
                                success: function(response) {
                                    if (response.success) {
                                        // Show success message
                                        Swal.fire({
                                            text: response.message,
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        }).then(function() {
                                            // Close modal
                                            $('#recordPaymentModal').modal(
                                                'hide');
                                            // Reload datatable
                                            $('#payment_schedules_table')
                                                .DataTable().ajax.reload();
                                        });
                                    } else {
                                        // Show error message
                                        Swal.fire({
                                            text: response.message,
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    // Show error message
                                    Swal.fire({
                                        text: "Sorry, looks like there are some errors detected, please try again.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
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
                        }
                    });
                });
            }

            return {
                // Public functions
                init: function() {
                    // Elements
                    form = document.querySelector('#recordPaymentForm');
                    submitButton = form.querySelector('#submitPayment');

                    initForm();
                    handleForm();
                }
            };
        }();

        // On document ready
        $(document).ready(function() {
            KTRecordPayment.init();
        });
    </script>
@endpush
