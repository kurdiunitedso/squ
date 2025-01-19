{{-- resources/views/CP/payments/modals/edit-plan.blade.php --}}
<div class="modal fade" id="editPlanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="editPlanForm" method="POST" action="{{ route('payments.update-plan', $paymentPlan->id) }}">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h2 class="fw-bold">Edit Payment Plan</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>

                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    {{-- Payment Frequency --}}
                    <div class="row mb-5">
                        <div class="col">
                            <label class="required form-label">Payment Frequency</label>
                            <select class="form-select" name="payment_frequency" required>
                                <option value="monthly"
                                    {{ $paymentPlan->payment_frequency == 'monthly' ? 'selected' : '' }}>Monthly
                                </option>
                                <option value="quarterly"
                                    {{ $paymentPlan->payment_frequency == 'quarterly' ? 'selected' : '' }}>Quarterly
                                </option>
                                <option value="yearly"
                                    {{ $paymentPlan->payment_frequency == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>
                        </div>
                    </div>

                    {{-- Start Date --}}
                    <div class="row mb-5">
                        <div class="col">
                            <label class="required form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date" required {{-- value="{{ $paymentPlan->start_date->format('Y-m-d') }}" --}}
                                value="{{ $paymentPlan->start_date }}">
                            <div class="form-text">Changing this will affect all future payment dates</div>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="row mb-5">
                        <div class="col">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="3">{{ $paymentPlan->notes }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitPlanEdit">
                        <span class="indicator-label">Save Changes</span>
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
        var KTEditPlan = function() {
            var submitButton;
            var form;
            var validator;

            // Init form validation rules
            var handleForm = function() {
                validator = FormValidation.formValidation(
                    form, {
                        fields: {
                            'payment_frequency': {
                                validators: {
                                    notEmpty: {
                                        message: 'Payment frequency is required'
                                    }
                                }
                            },
                            'start_date': {
                                validators: {
                                    notEmpty: {
                                        message: 'Start date is required'
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

                            // Submit form
                            form.submit();
                        }
                    });
                });
            }

            return {
                // Public functions
                init: function() {
                    // Elements
                    form = document.querySelector('#editPlanForm');
                    submitButton = form.querySelector('#submitPlanEdit');

                    handleForm();
                }
            };
        }();

        // On document ready
        $(document).ready(function() {
            KTEditPlan.init();
        });
    </script>
@endpush
