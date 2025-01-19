@php
    use App\Models\PaymentSchedule;
@endphp
@extends('metronic.index')

@section('content')
    {{-- Payment Progress Bar --}}
    <div class="card mb-5">
        <div class="card-body pt-3">
            <div class="d-flex align-items-center mb-8">
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold fs-6 text-gray-800">Payment Progress</span>
                        <span
                            class="fw-bold fs-6 text-primary">{{ number_format(($paymentPlan->total_paid / $paymentPlan->total_amount) * 100, 1) }}%</span>
                    </div>
                    <div class="h-8px w-100 bg-light-primary rounded">
                        <div class="bg-primary rounded h-8px" role="progressbar"
                            style="width: {{ ($paymentPlan->total_paid / $paymentPlan->total_amount) * 100 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Payment Summary Cards --}}
    <div class="row g-5 g-xl-8 mb-5">
        <div class="col-xl-3">
            <div class="card bg-light-primary card-xl-stretch mb-xl-8">
                <div class="card-body">
                    <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
                        <i class="ki-duotone ki-dollar fs-2hx"><span class="path1"></span><span class="path2"></span></i>
                    </span>
                    <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5 total-amount">
                        ${{ number_format($paymentPlan->total_amount, 2) }}
                    </div>
                    <div class="fw-semibold text-gray-400">Total Amount</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card bg-light-success card-xl-stretch mb-xl-8">
                <div class="card-body">
                    <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                        <i class="ki-duotone ki-check-circle fs-2hx"><span class="path1"></span><span
                                class="path2"></span></i>
                    </span>
                    <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5 paid-amount">
                        ${{ number_format($paymentPlan->total_paid, 2) }}
                    </div>
                    <div class="fw-semibold text-gray-400">Amount Paid</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card bg-light-warning card-xl-stretch mb-xl-8">
                <div class="card-body">
                    <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
                        <i class="ki-duotone ki-timer fs-2hx"><span class="path1"></span><span class="path2"></span></i>
                    </span>
                    <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5 remaining-amount">
                        ${{ number_format($paymentPlan->remaining_amount, 2) }}
                    </div>
                    <div class="fw-semibold text-gray-400">Remaining Amount</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3">
            <div class="card bg-light-info card-xl-stretch mb-xl-8">
                <div class="card-body">
                    <span class="svg-icon svg-icon-3x svg-icon-info d-block my-2">
                        <i class="ki-duotone ki-calendar fs-2hx"><span class="path1"></span><span
                                class="path2"></span></i>
                    </span>
                    <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5 next-payment-date">
                        {{ $paymentPlan->next_payment_date_formatted }}
                    </div>
                    <div class="fw-semibold text-gray-400">Next Payment Due</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Payment Plan Details --}}
    <div class="card mb-5">
        <div class="card-header">
            <h3 class="card-title">Payment Plan Details</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light-primary editPlanBtn"
                    data-href="{{ route('payment-plans.edit', $paymentPlan->id) }}">
                    <i class="ki-duotone ki-pencil fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Edit Plan
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="d-flex flex-column">
                        <div class="text-gray-600 fw-semibold mb-1">Down Payment</div>
                        <div class="text-gray-800 fw-bold">${{ number_format($paymentPlan->downpayment_amount, 2) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column">
                        <div class="text-gray-600 fw-semibold mb-1">Installment Amount</div>
                        <div class="text-gray-800 fw-bold">${{ number_format($paymentPlan->installment_amount, 2) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column">
                        <div class="text-gray-600 fw-semibold mb-1">Number of Installments</div>
                        <div class="text-gray-800 fw-bold">{{ $paymentPlan->number_of_installments }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex flex-column">
                        <div class="text-gray-600 fw-semibold mb-1">Payment Frequency</div>
                        <div class="text-gray-800 fw-bold">{{ ucfirst($paymentPlan->payment_frequency) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column">
                        <div class="text-gray-600 fw-semibold mb-1">Start Date</div>
                        <div class="text-gray-800 fw-bold">
                            {{ $paymentPlan->start_date ? \Carbon\Carbon::parse($paymentPlan->start_date)->format('M d, Y') : 'N/A' }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column">
                        <div class="text-gray-600 fw-semibold mb-1">Status</div>
                        <div>
                            <span class="badge"
                                style="background-color: {{ $paymentPlan->status->color }}; color: {{ getContrastColor($paymentPlan->status->color) }}">
                                {{ ucfirst($paymentPlan->status->name) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Payment Schedules Table --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Payment Schedules</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light-primary recordPaymentBtn"
                    data-href="{{ route(PaymentSchedule::ui['route'] . '.create', ['payment_plan_id' => $paymentPlan->id]) }}">
                    <i class="ki-duotone ki-plus fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Record Payment
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="payment_schedules_table" class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th>Type</th>
                        <th>Due Date</th>
                        <th>Amount</th>
                        <th>Paid Amount</th>
                        <th>Remaining</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @foreach ($paymentPlan->schedules as $schedule)
                        <tr>
                            <td>{{ ucfirst($schedule->paymentType->name) }}</td>
                            <td>{{ $schedule->due_date ? \Carbon\Carbon::parse($schedule->due_date)->format('M d, Y') : 'N/A' }}
                            </td>
                            <td>${{ number_format($schedule->amount, 2) }}</td>
                            <td>${{ number_format($schedule->paid_amount, 2) }}</td>
                            <td>${{ number_format($schedule->remaining_amount, 2) }}</td>
                            <td>
                                <span class="badge"
                                    style="background-color: {{ $schedule->status->color }}; color: {{ getContrastColor($schedule->status->color) }}">
                                    {{ ucfirst($schedule->status->name) }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-icon btn-light-primary btn-sm me-1 recordPaymentBtn"
                                    data-href="{{ route(PaymentSchedule::ui['route'] . '.record-payment', $schedule->id) }}">
                                    <i class="ki-duotone ki-dollar fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </button>
                                @if ($schedule->payment_type !== 'downpayment')
                                    <button type="button"
                                        class="btn btn-icon btn-light-warning btn-sm me-1 editScheduleBtn"
                                        data-href="{{ route(PaymentSchedule::ui['route'] . '.edit', $schedule->id) }}">
                                        <i class="ki-duotone ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Container --}}
    <div class="modal fade" id="kt_modal_general" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                {{-- Modal content will be loaded here --}}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Initialize DataTable
        const paymentSchedulesTable = $('#payment_schedules_table').DataTable({
            order: [
                [1, 'asc']
            ],
            pageLength: 25,
            responsive: true,
            buttons: [],
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            drawCallback: function() {
                KTMenu.createInstances();
            }
        });

        // Record Payment Button Click Handler
        $(document).on('click', '.recordPaymentBtn', function(e) {
            e.preventDefault();
            const button = $(this);
            button.attr("data-kt-indicator", "on");
            const url = $(this).data('href');

            ModalRenderer.render({
                url: url,
                button: button,
                modalId: '#kt_modal_general',
                modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general')),
                formId: '#recordPaymentForm',
                dataTableId: paymentSchedulesTable,
                submitButtonName: "[data-kt-modal-action='submitPayment']",
                callBackFunction: function() {
                    initializePaymentMethodHandling();
                },
                onFormSuccessCallBack: handlePaymentSuccess
            });
        });

        // Edit Schedule Button Click Handler
        $(document).on('click', '.editScheduleBtn', function(e) {
            e.preventDefault();
            const button = $(this);
            button.attr("data-kt-indicator", "on");
            const url = $(this).data('href');

            ModalRenderer.render({
                url: url,
                button: button,
                modalId: '#kt_modal_general',
                modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general')),
                formId: '#editScheduleForm',
                dataTableId: paymentSchedulesTable,
                submitButtonName: "[data-kt-modal-action='submitSchedule']"
            });
        });

        // Edit Plan Button Click Handler
        $(document).on('click', '.editPlanBtn', function(e) {
            e.preventDefault();
            const button = $(this);
            button.attr("data-kt-indicator", "on");
            const url = $(this).data('href');

            ModalRenderer.render({
                url: url,
                button: button,
                modalId: '#kt_modal_general',
                modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general')),
                formId: '#editPlanForm',
                dataTableId: paymentSchedulesTable,
                submitButtonName: "[data-kt-modal-action='submitPlan']"
            });
        });

        function initializePaymentMethodHandling() {
            $('select[name="payment_method_id"]').on('change', function() {
                const method = $(this).find('option:selected').text().toLowerCase();
                const bankFields = $('.bank-fields');
                const checkFields = $('.check-fields');

                if (method.includes('check') || method.includes('bank transfer')) {
                    bankFields.removeClass('d-none');
                    checkFields.toggleClass('d-none', !method.includes('check'));

                    // Handle required fields
                    if (method.includes('check')) {
                        $('input[name="check_number"]').prop('required', true);
                    } else {
                        $('input[name="check_number"]').prop('required', false);
                    }

                    $('select[name="bank_id"]').prop('required', true);
                } else {
                    bankFields.addClass('d-none');
                    checkFields.addClass('d-none');
                    $('select[name="bank_id"], input[name="check_number"]').prop('required', false);
                }
            });
        }

        function handlePaymentSuccess(response, form, modalBootstrap, dataTableId) {
            // Let the default callback handle basic operations
            ModalFormHandler.prototype.defaultSuccessCallback(response, form, modalBootstrap, dataTableId);

            // Update summary data
            if (response.data?.summary) {
                updateSummaryData(response.data.summary);
            }

            // Reload the current page to refresh all data
            window.location.reload();
        }

        function updateSummaryData(summary) {
            // Update all summary cards
            $('.total-amount').text(' + formatMoney(summary.total_amount));
                    $('.paid-amount').text(' + formatMoney(summary.paid_amount));
                        $('.remaining-amount').text(' + formatMoney(summary.remaining_amount));
                            $('.next-payment-date').text(summary.next_payment_date || 'N/A');

                            // Update progress bar
                            const progressPercentage = (summary.paid_amount / summary.total_amount) * 100;
                            const progressBar = $('.progress-bar'); progressBar.css('width', progressPercentage +
                                '%'); progressBar.attr('aria-valuenow', progressPercentage); $(
                                '.payment-progress-percentage')
                            .text(progressPercentage.toFixed(1) + '%');
                        }

                        function formatMoney(amount) {
                            return new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(amount);
                        }

                        // Document Ready Handler
                        $(document).ready(function() {
                            // Initialize tooltips
                            $('[data-bs-toggle="tooltip"]').tooltip();

                            // Initialize any existing payment method selects
                            initializePaymentMethodHandling();

                            // Handle validation errors highlighting
                            if (typeof validationErrors !== 'undefined' && validationErrors) {
                                Object.keys(validationErrors).forEach(function(field) {
                                    const element = $('[name="' + field + '"]');
                                    element.addClass('is-invalid');
                                    element.siblings('.invalid-feedback').text(validationErrors[field][0]);
                                });
                            }
                        });
    </script>
@endpush
