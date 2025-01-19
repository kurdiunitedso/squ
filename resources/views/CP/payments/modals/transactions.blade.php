<div class="modal-content">
    <div class="modal-header py-3 border-0">
        <h2 class="fw-bolder fs-3">{{ t('Payment Transactions') }}</h2>
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
            <i class="bi bi-x fs-2"></i>
        </div>
    </div>

    <div class="modal-body py-0">
        <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
            data-kt-scroll-max-height="500px" data-kt-scroll-offset="300px">
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="min-w-100px rounded-start ps-4">{{ t('Date') }}</th>
                            <th class="min-w-100px">{{ t('Amount') }}</th>
                            <th class="min-w-125px">{{ t('Method') }}</th>
                            <th class="min-w-150px">{{ t('Payment Details') }}</th>
                            <th class="min-w-100px">{{ t('Status') }}</th>
                            <th class="min-w-200px">{{ t('Notes') }}</th>
                            <th class="min-w-100px rounded-end">{{ t('Created At') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td class="ps-4">
                                    <span class="text-dark fw-semibold d-block mb-1">
                                        {{-- {{ $transaction->payment_date->format('Y-m-d') }} --}}
                                        {{ $transaction->payment_date }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-dark fw-bold fs-6">
                                        ${{ number_format($transaction->amount, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-30px me-3">
                                            @if ($transaction->paymentMethodLabel == 'Cash')
                                                <i class="bi bi-cash-coin fs-2 text-primary"></i>
                                            @elseif($transaction->paymentMethodLabel == 'Check')
                                                <i class="bi bi-credit-card fs-2 text-info"></i>
                                            @else
                                                <i class="bi bi-bank fs-2 text-success"></i>
                                            @endif
                                        </div>
                                        <span class="text-gray-800 fw-semibold">
                                            {{ $transaction->paymentMethodLabel }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    @if ($transaction->bank)
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-800 fw-semibold">
                                                {{ $transaction->bank->name }}
                                            </span>
                                            @if ($transaction->bank_branch)
                                                <span class="text-gray-600">
                                                    {{ t('Branch') }}: {{ $transaction->bank_branch }}
                                                </span>
                                            @endif
                                            @if ($transaction->bank_account)
                                                <span class="text-gray-600">
                                                    {{ t('Account') }}: {{ $transaction->bank_account }}
                                                </span>
                                            @endif
                                            @if ($transaction->check_number)
                                                <span class="text-gray-600">
                                                    {{ t('Check') }} #{{ $transaction->check_number }}
                                                </span>
                                            @endif
                                            @if ($transaction->reference_number)
                                                <span class="text-gray-600">
                                                    {{ t('Ref') }} #{{ $transaction->reference_number }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        @if ($transaction->reference_number)
                                            <span class="text-gray-600">
                                                {{ t('Ref') }} #{{ $transaction->reference_number }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">--</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-light-{{ $transaction->statusColor }} fw-bold px-4 py-3">
                                        {{ $transaction->statusLabel }}
                                    </span>
                                </td>
                                <td>
                                    @if ($transaction->notes)
                                        <span class="text-gray-600" data-bs-toggle="tooltip"
                                            title="{{ $transaction->notes }}">
                                            {{ Str::limit($transaction->notes, 50) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">--</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-gray-600">
                                        {{-- {{ $transaction->created_at->format('Y-m-d H:i') }} --}}
                                        {{ $transaction->created_at }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-500 py-10">
                                    <i class="bi bi-clipboard-x fs-2qx text-gray-300 d-block mb-4"></i>
                                    {{ t('No transactions found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-footer border-0 pt-5">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
            {{ t('Close') }}
        </button>
    </div>
</div>
