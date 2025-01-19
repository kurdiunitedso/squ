{{-- resources/views/CP/payments/create-plan.blade.php --}}
@extends('metronic.index')

@section('content')
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title">
                <h3>Create Payment Plan</h3>
            </div>
        </div>

        <div class="card-body">
            <form id="payment_plan_form" method="POST" action="{{ route('payments.create-plan', $sale->id) }}">
                @csrf

                {{-- Sale Summary --}}
                <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                    <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                        <i class="ki-duotone ki-information-5 fs-2qx text-primary">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </span>
                    <div class="d-flex flex-stack flex-grow-1">
                        <div class="fw-semibold">
                            <div class="fs-6 text-gray-700">
                                <strong>Sale Amount:</strong> ${{ number_format($sale->price, 2) }}<br>
                                <strong>Property:</strong> {{ $sale->apartment->name ?? 'N/A' }}<br>
                                <strong>Client:</strong> {{ $sale->client->name ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Hidden Fields --}}
                <input type="hidden" name="total_amount" value="{{ $sale->price }}">

                {{-- Down Payment --}}
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Down Payment Amount</label>
                    <div class="col-lg-8 fv-row">
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="downpayment_amount" class="form-control form-control-lg" required
                                step="0.01" min="0" max="{{ $sale->price }}"
                                value="{{ old('downpayment_amount') }}">
                        </div>
                        <div class="text-muted fs-7 mt-2">Enter the down payment amount</div>
                    </div>
                </div>

                {{-- Number of Installments --}}
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Number of Installments</label>
                    <div class="col-lg-8 fv-row">
                        <input type="number" name="number_of_installments" class="form-control form-control-lg" required
                            min="1" max="120" value="{{ old('number_of_installments', 12) }}">
                        <div class="text-muted fs-7 mt-2">Enter the number of installments (maximum 120)</div>
                    </div>
                </div>

                {{-- Payment Frequency --}}
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Payment Frequency</label>
                    <div class="col-lg-8 fv-row">
                        <select name="payment_frequency" class="form-select form-select-lg" required>
                            <option value="monthly" {{ old('payment_frequency') == 'monthly' ? 'selected' : '' }}>Monthly
                            </option>
                            <option value="quarterly" {{ old('payment_frequency') == 'quarterly' ? 'selected' : '' }}>
                                Quarterly</option>
                            <option value="yearly" {{ old('payment_frequency') == 'yearly' ? 'selected' : '' }}>Yearly
                            </option>
                        </select>
                    </div>
                </div>

                {{-- Start Date --}}
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Start Date</label>
                    <div class="col-lg-8 fv-row">
                        <input type="date" name="start_date" class="form-control form-control-lg" required
                            value="{{ old('start_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}">
                    </div>
                </div>

                {{-- Payment Summary (Updated dynamically via JavaScript) --}}
                <div class="separator my-10"></div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Payment Summary</label>
                    <div class="col-lg-8">
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Total Amount:</td>
                                        <td class="text-end">${{ number_format($sale->price, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Down Payment:</td>
                                        <td class="text-end" id="summary_downpayment">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Monthly Installment:</td>
                                        <td class="text-end" id="summary_installment">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Total Installments:</td>
                                        <td class="text-end" id="summary_total_installments">0</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Final Payment Date:</td>
                                        <td class="text-end" id="summary_final_date">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Notes</label>
                    <div class="col-lg-8 fv-row">
                        <textarea name="notes" class="form-control form-control-lg" rows="3">{{ old('notes') }}</textarea>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="card-footer d-flex justify-content-end py-6">
                    {{-- <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-light me-3">Cancel</a> --}}
                    <a href="{{ route('payments.index', $sale->id) }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" class="btn btn-primary" id="submit_plan">
                        <span class="indicator-label">
                            Create Payment Plan
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        "use strict";

        // Class definition
        var KTCreatePaymentPlan = function() {
            // Elements
            var form;
            var submitButton;
            var validator;

            // Handle form
            var handleForm = function(e) {
                // Init form validation rules
                validator = FormValidation.formValidation(
                    form, {
                        fields: {
                            'downpayment_amount': {
                                validators: {
                                    notEmpty: {
                                        message: 'Down payment amount is required'
                                    },
                                    numeric: {
                                        message: 'Down payment must be a number',
                                        thousandsSeparator: '',
                                        decimalSeparator: '.'
                                    },
                                    between: {
                                        min: 0,
                                        max: {{ $sale->price }},
                                        message: 'Down payment must be between 0 and sale amount'
                                    }
                                }
                            },
                            'number_of_installments': {
                                validators: {
                                    notEmpty: {
                                        message: 'Number of installments is required'
                                    },
                                    integer: {
                                        message: 'Please enter a valid number'
                                    },
                                    between: {
                                        min: 1,
                                        max: 120,
                                        message: 'Number of installments must be between 1 and 120'
                                    }
                                }
                            },
                            'start_date': {
                                validators: {
                                    notEmpty: {
                                        message: 'Start date is required'
                                    },
                                    date: {
                                        format: 'YYYY-MM-DD',
                                        message: 'Please enter a valid date'
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

                // Handle form submit
                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    validator.validate().then(function(status) {
                        if (status == 'Valid') {
                            submitButton.setAttribute('data-kt-indicator', 'on');
                            submitButton.disabled = true;

                            form.submit();
                        }
                    });
                });
            }

            // Calculate payment summary
            var calculatePaymentSummary = function() {
                var downpayment = parseFloat($('input[name="downpayment_amount"]').val()) || 0;
                var installments = parseInt($('input[name="number_of_installments"]').val()) || 1;
                var frequency = $('select[name="payment_frequency"]').val();
                var startDate = new Date($('input[name="start_date"]').val());

                var remainingAmount = {{ $sale->price }} - downpayment;
                var installmentAmount = remainingAmount / installments;

                // Update summary
                $('#summary_downpayment').text('$' + downpayment.toFixed(2));
                $('#summary_installment').text('$' + installmentAmount.toFixed(2));
                $('#summary_total_installments').text(installments);

                // Calculate final date
                var finalDate = new Date(startDate);
                if (frequency === 'monthly') {
                    finalDate.setMonth(finalDate.getMonth() + installments);
                } else if (frequency === 'quarterly') {
                    finalDate.setMonth(finalDate.getMonth() + (installments * 3));
                } else {
                    finalDate.setFullYear(finalDate.getFullYear() + installments);
                }

                $('#summary_final_date').text(finalDate.toLocaleDateString());
            }

            return {
                // Public functions
                init: function() {
                    // Elements
                    form = document.querySelector('#payment_plan_form');
                    submitButton = document.querySelector('#submit_plan');

                    handleForm();

                    // Initialize summary calculation
                    calculatePaymentSummary();

                    // Add event listeners for summary updates
                    $('input[name="downpayment_amount"], input[name="number_of_installments"], select[name="payment_frequency"], input[name="start_date"]')
                        .on('change', calculatePaymentSummary);
                }
            };
        }();

        // On document ready
        $(document).ready(function() {
            KTCreatePaymentPlan.init();
        });
    </script>
@endpush
