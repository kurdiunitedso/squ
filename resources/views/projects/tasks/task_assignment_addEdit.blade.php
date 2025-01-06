@php
    use App\Models\Project;
    use App\Models\Task;
    use App\Models\TaskAssignment;
    use App\Models\TaskProcess;
@endphp

<div class="modal-content task-modal">

    <div class="modal-header d-flex align-items-center justify-content-between">
        <!-- Left side with title -->
        <h5 class="modal-title d-flex align-items-center gap-2">
            <i class="fas fa-tasks text-primary"></i>
            {{ $task->title }}
        </h5>

        <!-- Right side with buttons -->
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-light" data-kt-{{ TaskAssignment::ui['s_lcf'] }}-modal-action="cancel"
                data-bs-dismiss="modal">
                {{ __('Discard') }}
            </button>
            <button type="button" class="btn btn-primary"
                data-kt-{{ TaskAssignment::ui['s_lcf'] }}-modal-action="submit">
                <span class="indicator-label">{{ __('Submit') }}</span>
                <span class="indicator-progress">{{ __('Please wait...') }}
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
            {{-- <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button> --}}
        </div>
    </div>

    <div class="modal-body task-modal-body">
        <form id="kt_modal_add_{{ TaskAssignment::ui['s_lcf'] }}_form" class="form"
            data-editMode="{{ isset($item_model) ? 'enabled' : 'disabled' }}"
            action="{{ route(Project::ui['route'] . '.' . Task::ui['route'] . '.storeTaskAssignment', [Project::ui['s_lcf'] => $project->id, Task::ui['s_lcf'] => $task->id, TaskAssignment::ui['s_lcf'] => $item_model->id]) }}">


            <!-- Basic Information Section -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-info-circle"></i>
                    {{ t('Basic Information') }}
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group fv-row"> <!-- Add fv-row class -->
                            <label class="form-label required">{{ t('Title') }}</label>
                            <input name="title" class="form-control form-control-solid validate-required"
                                value="{{ isset($item_model) ? $item_model->title : '' }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group fv-row">
                            <label class="form-label required">{{ t('Status') }}</label>
                            <select class="form-select form-select-solid validate-required" name="status_id"
                                data-control="select2" data-placeholder="Select an option">
                                <option></option>
                                @foreach ($status_list as $status)
                                    <option value="{{ $status->id }}"
                                        {{ old('status_id', $item_model->status_id ?? '') == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Add this right after the description textarea in your form -->
                    <div class="col-12">
                        <div class="form-group fv-row">
                            <label class="form-label required">{{ t('Description') }}</label>
                            <textarea name="description" class="form-control form-control-solid validate-required" rows="3">{{ isset($item_model) ? $item_model->description : '' }}</textarea>

                            <!-- Dropzone Container -->
                            <div class="dropzone-container mt-3">
                                <div id="taskAttachmentDropzone" class="dropzone">
                                    <div class="dz-message needsclick">
                                        <i class="fas fa-cloud-upload-alt fs-3x text-primary mb-2"></i>
                                        <div class="ms-4">
                                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">
                                                {{ t('Drop files here or click to upload') }}</h3>
                                            <span
                                                class="fs-7 fw-semibold text-gray-400">{{ t('Upload up to 10 files') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Single container for all files -->
                                <div class="existing-files mt-3">
                                    <div class="existing-files-list">
                                        <!-- Files will be added here dynamically -->
                                        @if (isset($item_model) && $item_model->attachments->count() > 0)
                                            @foreach ($item_model->attachments as $attachment)
                                                <div class="existing-file-item d-flex align-items-center p-2"
                                                    id="attachment-{{ $attachment->id }}">
                                                    <i class="fas fa-file me-2 text-primary"></i>
                                                    <span
                                                        class="file-name flex-grow-1">{{ $attachment->file_name }}</span>
                                                    <div class="file-actions">
                                                        <a href="{{ asset($attachment->file_path) }}"
                                                            class="btn btn-icon btn-sm btn-light me-2" target="_blank">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-light-danger delete-attachment"
                                                            data-attachment-id="{{ $attachment->id }}">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <!-- Timeline Section -->
            <!-- Timeline Section -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-calendar"></i>
                    {{ t('Timeline') }}
                </div>
                <div class="row g-4">
                    <!-- Planned Dates -->
                    <div class="col-12">
                        <h6 class="text-gray-700 mb-3">{{ t('Planned Timeline') }}</h6>
                    </div>

                    <!-- Start Date field -->
                    <div class="col-md-6">
                        <div class="form-group fv-row">
                            <label class="form-label required">{{ t('Start Date') }}</label>
                            <div class="date-picker-wrapper">
                                <span class="svg-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input type="text" name="{{ TaskAssignment::ui['s_lcf'] }}_start_date"
                                    class="form-control form-control-solid flatpickr-input validate-required"
                                    value="{{ old(TaskAssignment::ui['s_lcf'] . '_start_date', isset($item_model) ? $item_model->start_date : '') }}" />
                            </div>
                        </div>
                    </div>

                    <!-- End Date field -->
                    <div class="col-md-6">
                        <div class="form-group fv-row">
                            <label class="form-label">{{ t('End Date') }}</label>
                            <div class="date-picker-wrapper">
                                <span class="svg-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input type="text" name="{{ TaskAssignment::ui['s_lcf'] }}_end_date"
                                    class="form-control form-control-solid flatpickr-input"
                                    value="{{ old(TaskAssignment::ui['s_lcf'] . '_end_date', isset($item_model) ? $item_model->end_date : '') }}" />
                            </div>
                        </div>
                    </div>

                    <!-- Actual Timeline Section -->
                    <div class="col-12">
                        <div class="actual-timeline mt-4">
                            <h6 class="text-gray-700 mb-3">{{ t('Actual Timeline') }}</h6>
                            <div class="row g-4">
                                <!-- Actual Start Date -->
                                <div class="col-md-4">
                                    <div class="actual-date-box">
                                        <label class="form-label d-block">{{ t('Actual Start Date') }}</label>
                                        <div class="form-control-plaintext">
                                            @if ($item_model->actual_start_date)
                                                {{ \Carbon\Carbon::parse($item_model->actual_start_date)->format('Y-m-d') }}
                                            @else
                                                <span class="text-muted">{{ t('Not started yet') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Actual End Date -->
                                <div class="col-md-4">
                                    <div class="actual-date-box">
                                        <label class="form-label d-block">{{ t('Actual End Date') }}</label>
                                        <div class="form-control-plaintext">
                                            @if ($item_model->actual_end_date)
                                                {{ \Carbon\Carbon::parse($item_model->actual_end_date)->format('Y-m-d') }}
                                            @else
                                                <span class="text-muted">{{ t('Not completed yet') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Days -->
                                <div class="col-md-4">
                                    <div class="actual-date-box">
                                        <label class="form-label d-block">{{ t('Total Days') }}</label>
                                        <div class="form-control-plaintext">
                                            @if ($item_model->actual_days)
                                                {{ $item_model->actual_days }} {{ t('days') }}
                                            @else
                                                <span class="text-muted">{{ t('Pending') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Section -->
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-toggle-on"></i>
                    {{ t('Status & Details') }}
                </div>
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="taskActive" name="active"
                            @checked($item_model->active)>
                        <label class="form-check-label" for="taskActive">{{ t('Active') }}</label>
                    </div>
                </div>
                <div class="task-details bg-light p-3 rounded">
                    <h6 class="text-gray-700 mb-2">{{ t('Additional Details:') }}</h6>
                    <p class="text-gray-600 mb-0" id="taskAdditionalDetails">
                        {{ $item_model->additional_details ?? '' }}</p>
                </div>
            </div>

            <!-- Task Process Section -->
            <div class="task-process">
                <div class="task-process-header">
                    <div class="task-process-title">
                        <i class="fas fa-history"></i>
                        {{ t('Task Process History') }}
                    </div>
                </div>
                <div class="task-process-list">
                    @foreach ($task_processes as $process)
                        <div class="task-process-item" onclick="openProcessComments({{ $process->id }})">
                            <div class="task-process-content">
                                <div class="task-process-avatar">
                                    {{ substr($process->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="task-process-info">
                                    <div class="task-process-user">
                                        {{ $process->user->name ?? 'Unknown User' }}
                                        <span
                                            class="task-process-time">{{ $process->created_at->diffForHumans() }}</span>
                                    </div>

                                    @if ($process->type->constant_name === 'status_change' || $process->type->constant_name === 'active')
                                        <div class="task-process-details">
                                            <div class="task-status-change">
                                                <span>{{ $process->old_value }}</span>
                                                <span class="task-status-arrow">→</span>
                                                <span class="task-status-new">{{ $process->new_value }}</span>
                                                <span
                                                    class="text-gray-500">({{ t($process->type->constant_name === 'status_change' ? 'Status' : 'Active Flag') }})</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="task-process-details">
                                            {{ $process->notes }}
                                        </div>
                                    @endif

                                    <div class="task-process-comments">
                                        <i class="fas fa-comments"></i>
                                        <span>{{ $process->comments_count }} {{ t('comments') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- <!--begin::Actions-->
            <div class="text-center pt-15">
                <button type="button" class="btn btn-light me-3" data-kt-contract_item-modal-action="cancel"
                    data-bs-dismiss="modal">
                    {{ __('Discard') }}
                </button>
                <button type="button" class="btn btn-primary"
                    data-kt-{{ TaskAssignment::ui['s_lcf'] }}-modal-action="submit">
                    <span class="indicator-label">{{ __('Submit') }}</span>
                    <span class="indicator-progress">{{ __('Please wait...') }}
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
            <!--end --}}
        </form>
    </div>
</div>
