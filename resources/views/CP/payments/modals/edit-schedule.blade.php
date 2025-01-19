{{-- resources/views/CP/payments/modals/edit-schedule.blade.php --}}
<div class="modal fade" id="editScheduleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form id="editScheduleForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_schedule_id" name="schedule_id">

                <div class="modal-header">
                    <h2 class="fw-bold">Edit Payment Schedule</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>

                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    {{-- Due Date --}}
                    <div class="row mb-5">
                        <div class="col">
                            <label class="required form-label">Due Date</label>
                            <input type="date" class="form-control" name="due_date" id="edit_due_date" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    {{-- Amount --}}
                    <div class="row mb-5">
                        <div class="col">
                            <label class="required form-label">Amount</label>
                            <input type="number" class="form-control" name="amount" id="edit_amount" required
                                step="0.01" min="0.01">
                            <div class="invalid-feedback"></div>
                            <div class="form-text" id="paid_amount_info"></div>
                        </div>
                    </div>

                    {{-- Bank Details (if applicable) --}}
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <label class="form-label">Bank</label>
                            <select class="form-select" name="bank_id" id="edit_bank_id" data-control="select2"
                                data-placeholder="Select Bank">
                                <option></option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Check Number</label>
                            <input type="text" class="form-control" name="check_number" id="edit_check_number">
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="row mb-5">
                        <div class="col">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" id="edit_notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitScheduleEdit">
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
