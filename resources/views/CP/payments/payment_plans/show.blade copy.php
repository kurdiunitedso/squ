{{-- resources/views/CP/payments/index.blade.php --}}
@extends('metronic.index')

@section('content')
    {{-- Payment Summary Cards --}}
    <div class="row g-5 g-xl-8 mb-5">
        <div class="col-xl-3">
            <div class="card bg-light-primary card-xl-stretch mb-xl-8">
                <div class="card-body">
                    <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
                        <i class="ki-duotone ki-dollar fs-2hx"></i>
                    </span>
                    <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">
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
                        <i class="ki-duotone ki-check-circle fs-2hx"></i>
                    </span>
                    <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">
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
                        <i class="ki-duotone ki-timer fs-2hx"></i>
                    </span>
                    <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">
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
                        <i class="ki-duotone ki-calendar fs-2hx"></i>
                    </span>
                    <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">

                        {{ $paymentPlan->next_payment_date_formatted }} </div>
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
                <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                    data-bs-target="#editPlanModal">
                    <i class="ki-duotone ki-pencil fs-2"></i>
                    Edit Plan
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="fw-bold">Down Payment:</div>
                    <div>${{ number_format($paymentPlan->downpayment_amount, 2) }}</div>
                </div>
                <div class="col-md-4">
                    <div class="fw-bold">Installment Amount:</div>
                    <div>${{ number_format($paymentPlan->installment_amount, 2) }}</div>
                </div>
                <div class="col-md-4">
                    <div class="fw-bold">Number of Installments:</div>
                    <div>{{ $paymentPlan->number_of_installments }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="fw-bold">Payment Frequency:</div>
                    <div>{{ ucfirst($paymentPlan->payment_frequency) }}</div>
                </div>
                <div class="col-md-4">
                    <div class="fw-bold">Start Date:</div>
                    {{-- <div>{{ $paymentPlan->start_date->format('M d, Y') }}</div> --}}
                    <div>{{ $paymentPlan->start_date }}</div>
                </div>
                <div class="col-md-4">
                    <div class="fw-bold">Status:</div>
                    <div>
                        <span class="badge badge-light-{{ $paymentPlan->status_color }}">
                            {{ ucfirst($paymentPlan->status) }}
                        </span>
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
                <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                    data-bs-target="#recordPaymentModal"> <!-- Changed from #addPaymentModal -->
                    <i class="ki-duotone ki-plus fs-2"></i>
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
                <tbody>
                    @foreach ($paymentPlan->schedules as $schedule)
                        <tr>
                            <td>{{ ucfirst($schedule->payment_type) }}</td>
                            {{-- <td>{{ $schedule->due_date->format('M d, Y') }}</td> --}}
                            <td>{{ $schedule->due_date }}</td>
                            <td>${{ number_format($schedule->amount, 2) }}</td>
                            <td>${{ number_format($schedule->paid_amount, 2) }}</td>
                            <td>${{ number_format($schedule->remaining_amount, 2) }}</td>
                            <td>
                                <span class="badge badge-light-{{ $schedule->status_color }}">
                                    {{ ucfirst($schedule->status) }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-icon btn-light-primary btn-sm me-1"
                                    data-bs-toggle="modal" data-bs-target="#recordPaymentModal"
                                    data-schedule-id="{{ $schedule->id }}"
                                    data-amount="{{ $schedule->remaining_amount }}">
                                    <i class="ki-duotone ki-dollar fs-2"></i>
                                </button>
                                @if ($schedule->payment_type !== 'downpayment')
                                    <button type="button" class="btn btn-icon btn-light-warning btn-sm me-1"
                                        data-bs-toggle="modal" data-bs-target="#editScheduleModal"
                                        data-schedule-id="{{ $schedule->id }}">
                                        <i class="ki-duotone ki-pencil fs-2"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Include Modals --}}
    {{-- @include('CP.payments.modals.record-payment') --}}
    @include('CP.payments.modals.edit-schedule')
    @include('CP.payments.modals.edit-plan')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            const table = $('#payment_schedules_table').DataTable({
                order: [
                    [1, 'asc']
                ],
                pageLength: 25
            });

            // Record Payment Modal Handler
            $('#recordPaymentModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const scheduleId = button.data('schedule-id');
                const amount = button.data('amount');

                const modal = $(this);
                modal.find('#schedule_id').val(scheduleId);
                modal.find('#payment_amount').attr('max', amount);
                modal.find('#payment_amount').val(amount);
            });

            // Payment Method Change Handler
            $('#payment_method').on('change', function() {
                const method = $(this).val();
                toggleBankFields(method);
            });

            function toggleBankFields(method) {
                const bankFields = $('.bank-fields');
                const checkFields = $('.check-fields');

                if (method === 'check' || method === 'bank_transfer') {
                    bankFields.show();
                    checkFields.toggle(method === 'check');
                } else {
                    bankFields.hide();
                    checkFields.hide();
                }
            }
        });
    </script>
@endpush
