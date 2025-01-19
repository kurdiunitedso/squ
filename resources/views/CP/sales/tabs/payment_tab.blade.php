@php
    use App\Models\Lead;
    use App\Models\Client;
    use App\Models\Apartment;
    use App\Models\AddOn;
    use App\Models\Sale;
@endphp
<div class="tab-pane fade show" id="kt_tab_pane_{{ 'payments_overview' }}" role="tabpanel">
    @if (!$_model->hasPaymentPlan())
        {{-- Show Create Payment Plan Card --}}
        <div class="card">
            <div class="card-body d-flex flex-column align-items-center py-10">
                <i class="ki-duotone ki-dollar fs-5x mb-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <div class="fw-bold fs-3 mb-2">{{ t('No Payment Plan Created Yet') }}</div>
                <div class="text-gray-400 mb-6">
                    {{ t('Create a payment plan to manage installments and track payments') }}</div>

                <a href="{{ route('payments.create-plan', ['sale' => $_model->id]) }}" class="btn btn-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>
                    {{ t('Create Payment Plan') }}
                </a>
            </div>
        </div>
    @else
        {{-- Payment Summary Cards --}}
        <div class="row g-5 g-xl-8 mb-5">
            <div class="col-xl-3">
                <div class="card bg-light-primary card-xl-stretch mb-xl-8">
                    <div class="card-body">
                        <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
                            <i class="ki-duotone ki-dollar fs-2hx"></i>
                        </span>
                        <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5 total-amount">
                            ${{ number_format($_model->price, 2) }}
                        </div>
                        <div class="fw-semibold text-gray-400">{{ t('Total Amount') }}</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card bg-light-success card-xl-stretch mb-xl-8">
                    <div class="card-body">
                        <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                            <i class="ki-duotone ki-check-circle fs-2hx"></i>
                        </span>
                        <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5 paid-amount">
                            ${{ number_format($_model->total_paid, 2) }}
                        </div>
                        <div class="fw-semibold text-gray-400">{{ t('Total Paid') }}</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card bg-light-warning card-xl-stretch mb-xl-8">
                    <div class="card-body">
                        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
                            <i class="ki-duotone ki-timer fs-2hx"></i>
                        </span>
                        <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5 remaining-amount">
                            ${{ number_format($_model->remaining_amount, 2) }}
                        </div>
                        <div class="fw-semibold text-gray-400">{{ t('Remaining Amount') }}</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card bg-light-info card-xl-stretch mb-xl-8">
                    <div class="card-body">
                        <span class="svg-icon svg-icon-3x svg-icon-info d-block my-2">
                            <i class="ki-duotone ki-calendar fs-2hx"></i>
                        </span>
                        <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5 next-payment-date">
                            {{ $_model->paymentPlan->next_payment_date_formatted }}
                        </div>
                        <div class="fw-semibold text-gray-400">{{ t('Next Payment Due') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Payment Plan Details --}}
        <div class="card mb-5">
            <div class="card-header">
                <div class="card-title">{{ t('Payment Plan Details') }}</div>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                        data-bs-target="#recordPaymentModal">
                        <i class="ki-duotone ki-plus fs-2"></i>
                        {{ t('Record Payment') }}
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="payment_schedules_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>{{ t('Payment Type') }}</th>
                            <th>{{ t('Due Date') }}</th>
                            <th>{{ t('Amount') }}</th>
                            <th>{{ t('Paid Amount') }}</th>
                            <th>{{ t('Remaining') }}</th>
                            <th>{{ t('Status') }}</th>
                            <th>{{ t('Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        {{-- Include Payment Modals --}}
        {{-- @include('CP.payments.modals.record-payment') --}}
    @endif
</div>
