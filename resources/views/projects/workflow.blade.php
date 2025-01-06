@php
    use App\Models\Employee;
    use App\Models\Constant;
    use App\Enums\Modules;
    use App\Enums\DropDownFields;

    $employees = Employee::get();
    $positions = Constant::where('module', Modules::Employee)
        ->Where('field', DropDownFields::position)
        ->get();
@endphp

<div class="wf-assignments">
    <div class="header-section">
        <h4 class="fw-bold">{{ t('Workflow Assignments') }}</h4>
        <button type="button" class="wf-add-btn" id="add-workflow-row">
            <i class="ki-duotone ki-plus fs-2"></i>
            {{ t('Add Employee') }}
        </button>
    </div>

    <div id="workflow-repeater">
        <!-- Rows will be added here -->
    </div>

    <button type="button" class="wf-save-btn" id="save-workflow">
        {{ t('Save Workflow') }}
    </button>
</div>

<!-- Template for repeater row -->
<!-- Template for repeater row -->
<template id="workflow-row-template">
    <div class="wf-row"> <!-- This entire div will be draggable -->
        <div class="wf-form-group">
            <div class="row g-4">
                <div class="col-md-5">
                    <label class="wf-label required">{{ t('Employee') }}</label>
                    <select class="form-select wf-select employee-select" data-control="select2"
                        name="workflow[{index}][employee_id]">
                        <option value="">{{ t('Select Employee') }}</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5">
                    <label class="wf-label required">{{ t('Position') }}</label>
                    <select class="form-select wf-select position-select" data-control="select2"
                        name="workflow[{index}][position_id]">
                        <option value="">{{ t('Select Position') }}</option>
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end justify-content-end">
                    <button type="button" class="wf-delete-btn remove-row">
                        <i class="ki-duotone ki-trash fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
