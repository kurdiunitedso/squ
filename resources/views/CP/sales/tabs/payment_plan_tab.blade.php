<!--begin::Card-->
<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ t('Create Payment Plan') }}</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->

    <!--begin::Card body-->
    <div class="card mb-5 mb-xl-10">
        <div class="card-body p-9">
            <div class="row">
                <!--begin::Sale Summary-->
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
                                <strong>{{ t('Sale Amount:') }}</strong> ${{ number_format($_model->price, 2) }}<br>
                                <strong>{{ t('Property:') }}</strong> {{ $_model->apartment->name ?? 'N/A' }}<br>
                                <strong>{{ t('Client:') }}</strong> {{ $_model->client->name ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Sale Summary-->

                <!-- Hidden Fields -->
                <input type="hidden" name="payment_plan_total_amount" value="{{ $_model->price }}">

                <!--begin::Down Payment-->
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2 required">{{ t('Down Payment Amount') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="payment_plan_downpayment_amount"
                                class="form-control form-control-solid validate-required @error('payment_plan_downpayment_amount') is-invalid @enderror"
                                placeholder="{{ t('Enter Down Payment Amount') }}"
                                value="{{ old('payment_plan_downpayment_amount') }}" min="0"
                                max="{{ $_model->price }}" step="0.01" required />
                        </div>
                        @error('payment_plan_downpayment_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="text-muted fs-7 mt-2">{{ t('Enter the down payment amount') }}</div>
                    </div>
                </div>
                <!--end::Down Payment-->
                <!--begin::Balloon Payment-->
                <div class="col-md-4" id="balloon_payment_section">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2 required">{{ t('Balloon Payment Amount') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="balloon_payment_amount"
                                class="form-control form-control-solid validate-required validate-min-0"
                                placeholder="{{ t('Enter Balloon Payment Amount') }}"
                                value="{{ old('balloon_payment_amount') }}" min="0" step="0.01" />
                        </div>
                        @error('balloon_payment_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="text-muted fs-7 mt-2">{{ t('Enter the balloon payment amount') }}</div>
                    </div>
                </div>
                <!--end::Balloon Payment-->

                <!--begin::Number of Installments-->
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2 required">{{ t('Number of Installments') }}</label>
                        <input type="number" name="payment_plan_number_of_installments"
                            class="form-control form-control-solid validate-required @error('payment_plan_number_of_installments') is-invalid @enderror"
                            placeholder="{{ t('Enter Number of Installments') }}"
                            value="{{ old('payment_plan_number_of_installments', 12) }}" min="1" max="120"
                            required />
                        @error('payment_plan_number_of_installments')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="text-muted fs-7 mt-2">{{ t('Enter the number of installments (maximum 120)') }}
                        </div>
                    </div>
                </div>
                <!--end::Number of Installments-->

                <!--begin::Payment Frequency-->
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2 required">{{ t('Payment Frequency') }}</label>
                        <select name="payment_plan_payment_frequency"
                            class="form-select form-select-solid validate-required @error('payment_plan_payment_frequency') is-invalid @enderror"
                            required>
                            <option value="">{{ t('Select Payment Frequency') }}</option>
                            <option value="monthly"
                                {{ old('payment_plan_payment_frequency') == 'monthly' ? 'selected' : '' }}>
                                {{ t('Monthly') }}
                            </option>
                            <option value="quarterly"
                                {{ old('payment_plan_payment_frequency') == 'quarterly' ? 'selected' : '' }}>
                                {{ t('Quarterly') }}
                            </option>
                            <option value="yearly"
                                {{ old('payment_plan_payment_frequency') == 'yearly' ? 'selected' : '' }}>
                                {{ t('Yearly') }}
                            </option>
                        </select>
                        @error('payment_plan_payment_frequency')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!--end::Payment Frequency-->

                <!--begin::Start Date-->
                <div class="col-md-4">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2 required">{{ t('Start Date') }}</label>
                        <div class="position-relative d-flex align-items-center">
                            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                        fill="currentColor" />
                                    <path
                                        d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <input type="text" name="payment_plan_start_date"
                                class="form-control form-control-solid ps-12 flatpickr-input validate-required date-picker-future @error('payment_plan_start_date') is-invalid @enderror"
                                placeholder="{{ t('Select Date') }}"
                                value="{{ old('payment_plan_start_date', date('Y-m-d')) }}" required />
                        </div>
                        @error('payment_plan_start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!--end::Start Date-->

                <!--begin::Payment Summary-->
                <div class="col-md-12">
                    <div class="separator my-10"></div>
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">{{ t('Payment Summary') }}</label>
                        <div class="col-lg-8">
                            <div class="table-responsive">
                                <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold">{{ t('Total Amount:') }}</td>
                                            <td class="text-end">${{ number_format($_model->price, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ t('Down Payment:') }}</td>
                                            <td class="text-end" id="summary_downpayment">$0.00</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ t('Monthly Installment:') }}</td>
                                            <td class="text-end" id="summary_installment">$0.00</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ t('Total Installments:') }}</td>
                                            <td class="text-end" id="summary_total_installments">0</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">{{ t('Final Payment Date:') }}</td>
                                            <td class="text-end" id="summary_final_date">-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Payment Summary-->

                <!--begin::Notes-->
                <div class="col-md-12">
                    <div class="fv-row mb-7">
                        <label class="fw-semibold fs-6 mb-2">{{ t('Notes') }}</label>
                        <textarea name="notes" class="form-control form-control-solid @error('notes') is-invalid @enderror" rows="3"
                            placeholder="{{ t('Enter notes') }}">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!--end::Notes-->
            </div>
        </div>
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->

@push('scripts')
    <script>
        "use strict";

        // Class definition
        var KTCreatePaymentPlan = function() {
            // Calculate payment summary
            var calculatePaymentSummary = function() {
                var totalAmount = {{ $_model->price }};
                var downpayment = parseFloat($('input[name="payment_plan_downpayment_amount"]').val()) || 0;
                var balloonPayment = parseFloat($('input[name="balloon_payment_amount"]').val()) || 0;
                var installments = parseInt($('input[name="payment_plan_number_of_installments"]').val()) || 1;
                var frequency = $('select[name="payment_plan_payment_frequency"]').val();
                var startDate = new Date($('input[name="payment_plan_start_date"]').val());

                // Calculate remaining amount after down payment and balloon payment
                var remainingAmount = totalAmount - downpayment - balloonPayment;
                var installmentAmount = remainingAmount / installments;

                // Update summary
                $('#summary_downpayment').text('$' + downpayment.toFixed(2));
                $('#summary_installment').text('$' + installmentAmount.toFixed(2));
                $('#summary_total_installments').text(installments);

                // Add balloon payment to summary if exists
                if (balloonPayment > 0) {
                    // Check if balloon payment row exists, if not create it
                    if ($('#summary_balloon_payment_row').length === 0) {
                        $('#summary_downpayment').closest('tr').after(`
                            <tr id="summary_balloon_payment_row">
                                <td class="fw-bold">{{ t('Balloon Payment:') }}</td>
                                <td class="text-end" id="summary_balloon_payment">$0.00</td>
                            </tr>
                        `);
                    }
                    $('#summary_balloon_payment').text('$' + balloonPayment.toFixed(2));
                } else {
                    $('#summary_balloon_payment_row').remove();
                }

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

                // Validate total amounts don't exceed property price
                var totalPayments = downpayment + balloonPayment + (installmentAmount * installments);
                if (Math.abs(totalPayments - totalAmount) > 0.01) { // Using 0.01 to handle floating point precision
                    Swal.fire({
                        text: "Total payments (down payment + installments + balloon payment) must equal the property price.",
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            }

            return {
                init: function() {
                    // Initialize summary calculation
                    calculatePaymentSummary();

                    // Add event listeners for summary updates
                    $('input[name="payment_plan_downpayment_amount"], input[name="payment_plan_number_of_installments"], input[name="balloon_payment_amount"], select[name="payment_plan_payment_frequency"], input[name="payment_plan_start_date"]')
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
