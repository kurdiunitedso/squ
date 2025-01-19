<div class="modal-content">
    <form id="recordPaymentForm" method="POST" class="form"
        action="{{ route('payments.record', ['schedule' => $schedule->id]) }}">
        @csrf
        <div class="modal-header py-4">
            <h2 class="fw-bold modal-title">{{ t('Record Payment') }}</h2>
            <div class="btn btn-icon btn-sm btn-light-primary ms-2" data-bs-dismiss="modal">
                <span class="svg-icon svg-icon-2">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                            transform="rotate(-45 6 17.3137)" fill="currentColor" />
                        <rect x="7.41422" y="6" width="16" height="2" rx="1"
                            transform="rotate(45 7.41422 6)" fill="currentColor" />
                    </svg>
                </span>
            </div>
        </div>

        <div class="modal-body py-8">
            <div class="scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                data-kt-scroll-max-height="auto" data-kt-scroll-offset="300px">

                {{-- Payment Information Section --}}
                <div class="mb-8">
                    <h3 class="mb-6 fs-4 fw-semibold text-gray-800">{{ t('Payment Information') }}</h3>

                    <div class="row g-6">
                        {{-- Payment Date Field --}}
                        <div class="col-md-6">
                            <div class="fv-row">
                                <label class="required fw-semibold fs-6 mb-2">{{ t('Payment Date') }}</label>
                                <div class="position-relative">
                                    <span class="svg-icon svg-icon-2 position-absolute translate-middle-y top-50 ms-4">
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
                                    <input type="text" name="payment_date"
                                        class="form-control form-control-solid ps-12 flatpickr-input date-picker validate-required date-picker-max"
                                        placeholder="{{ t('Select Date') }}" />
                                </div>
                                <div class="invalid-feedback">{{ t('Please select payment date') }}</div>
                            </div>
                        </div>

                        {{-- Payment Amount Field --}}
                        <div class="col-md-6">
                            <div class="fv-row">
                                <label class="required fw-semibold fs-6 mb-2">{{ t('Payment Amount') }}</label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text fs-4">$</span>
                                    <input type="number" name="amount"
                                        class="form-control form-control-solid validate-required validate-min-0"
                                        placeholder="{{ t('0.00') }}" value="{{ old('amount') }}"
                                        max="{{ $schedule->remaining_amount }}" step="0.01" />
                                </div>
                                <div class="text-muted fs-7 mt-1">{{ t('Maximum amount:') }}
                                    ${{ number_format($schedule->remaining_amount, 2) }}</div>
                            </div>
                        </div>

                        {{-- Payment Method Field --}}
                        <div class="col-md-12">
                            <div class="fv-row">
                                <label class="required fw-semibold fs-6 mb-2">{{ t('Payment Method') }}</label>
                                <select name="payment_method_id" class="form-select form-select-solid validate-required"
                                    data-control="select2" data-placeholder="{{ t('Select Payment Method') }}"
                                    data-hide-search="true">
                                    <option></option>
                                    @foreach ($payment_methods as $method)
                                        <option value="{{ $method->id }}">
                                            {{ $method->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bank Information Section --}}
                <div class="bank-fields d-none mb-8">
                    <h3 class="mb-6 fs-4 fw-semibold text-gray-800">{{ t('Bank Information') }}</h3>

                    <div class="row g-6">

                        {{-- Bank Field --}}
                        <div class="col-md-6">
                            <div class="fv-row">
                                <label class="required fw-semibold fs-6 mb-2">{{ t('Bank') }}</label>
                                <select name="bank_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="{{ t('Select Bank') }}">
                                    <option></option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">
                                            {{ $bank->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="fv-row">
                                <label class="fw-semibold fs-6 mb-2">{{ t('Branch') }}</label>
                                <input type="text" name="bank_branch" class="form-control form-control-solid"
                                    placeholder="{{ t('Enter Branch') }}" />
                            </div>
                        </div>
                    </div>

                    {{-- Check Information Section --}}
                    <div class="check-fields d-none mt-6">
                        <div class="row g-6">
                            <div class="col-md-6">
                                <div class="fv-row">
                                    <label class="required fw-semibold fs-6 mb-2">{{ t('Check Number') }}</label>
                                    <input type="text" name="check_number" class="form-control form-control-solid"
                                        placeholder="{{ t('Enter Check Number') }}" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row">
                                    <label class="fw-semibold fs-6 mb-2">{{ t('Check Date') }}</label>
                                    <div class="position-relative">
                                        <span
                                            class="svg-icon svg-icon-2 position-absolute translate-middle-y top-50 ms-4">
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
                                        <input type="text" name="check_date"
                                            class="form-control form-control-solid ps-12 flatpickr-input date-picker"
                                            placeholder="{{ t('Select Date') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Additional Information Section --}}
                <div class="mb-8">
                    <h3 class="mb-6 fs-4 fw-semibold text-gray-800">{{ t('Additional Information') }}</h3>

                    <div class="row g-6">
                        {{-- Reference Number Field --}}
                        <div class="col-md-12">
                            <div class="fv-row">
                                <label class="fw-semibold fs-6 mb-2">{{ t('Reference Number') }}</label>
                                <input type="text" name="reference_number" class="form-control form-control-solid"
                                    placeholder="{{ t('Enter Reference Number') }}" />
                            </div>
                        </div>

                        {{-- Notes Field --}}
                        <div class="col-md-12">
                            <div class="fv-row">
                                <label class="fw-semibold fs-6 mb-2">{{ t('Notes') }}</label>
                                <textarea name="notes" class="form-control form-control-solid" rows="4"
                                    placeholder="{{ t('Enter any additional notes') }}">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer py-5 border-top">
            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">
                <span class="indicator-label">{{ t('Cancel') }}</span>
            </button>
            <button type="submit" class="btn btn-primary" data-kt-modal-action="submitPayment">
                <span class="indicator-label">{{ t('Record Payment') }}</span>
                <span class="indicator-progress">
                    {{ t('Please wait...') }}
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    </form>
</div>
