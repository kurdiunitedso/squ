<div class="modal-content">
    <!-- Enhanced Header Section -->
    <div class="modal-task-header">
        <div class="task-header-bg">
            <div class="task-header-content">
                <h2 class="task-title">{{ $task->title }}</h2>
                <p class="task-description">{{ $task->description }}</p>
                <div class="task-badges">
                    <!-- Status Badge -->
                    <div class="task-badge status-badge"
                        style="background-color: {{ $item_model->status->color }}; color: #fff; padding: 0.5rem 1rem;">
                        <i class="fas fa-circle fs-8"></i>
                        {{ $item_model->status->name }}
                    </div>

                    <!-- Active Flag Badge -->
                    <div class="task-badge {{ $item_model->active ? 'active-badge' : 'inactive-badge' }}">
                        <i class="fas {{ $item_model->active ? 'fa-check-circle' : 'fa-times-circle' }} fs-2"></i>
                        {{ $item_model->active ? t('Active') : t('Inactive') }}
                    </div>

                </div>
            </div>
        </div>

        <!-- Quick Info Panel -->
        <div class="task-quick-info">
            <!-- Project Info -->
            <div class="info-item">
                <div class="info-icon" style="background: rgba(0, 158, 247, 0.1); color: #009ef7">
                    <i class="ki-duotone ki-briefcase fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <div class="info-content">
                    <div class="info-label">{{ t('Project') }}</div>
                    <div class="info-value">{{ $task->project->name ?? 'NA' }}</div>
                </div>
            </div>

            <!-- Assigned To -->
            <div class="info-item">
                <div class="info-icon employee">
                    <i class="ki-duotone ki-user fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <div class="info-content">
                    <div class="info-label">{{ t('Assigned To') }}</div>
                    <div class="info-value">{{ $item_model->employee->name }}</div>
                </div>
            </div>

            <!-- Priority Level -->
            <div class="info-item">
                <div class="info-icon active-state">
                    <i class="ki-duotone ki-flag fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <div class="info-content">
                    <div class="info-label">{{ t('Priority') }}</div>
                    <div class="info-value">{{ $task->priority->name ?? 'test' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-body tsk-modal-body">

        <div class="card shadow-none border-0">
            <!-- Timeline Overview Section -->
            <!-- Timeline Overview Section -->
            <div class="separator separator-dashed my-8"></div>
            <div class="px-2">
                <h3 class="fs-4 fw-bold d-flex align-items-center mb-6">
                    <i class="ki-duotone ki-timer fs-3 me-2 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    {{ t('Task Timeline Overview') }}
                </h3>

                <!-- Timeline Cards -->
                <div class="row g-5">
                    <!-- Planned Timeline Card -->
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header min-h-50px">
                                <h3 class="card-title fw-bold text-dark d-flex align-items-center">
                                    <i class="ki-duotone ki-calendar-8 fs-2 text-primary me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                    {{ t('Planned Timeline') }}
                                </h3>
                            </div>
                            <div class="card-body p-5">
                                <div class="d-flex flex-column gap-5">
                                    <!-- Planned Start Date -->
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="d-flex align-items-center justify-content-center w-35px h-35px rounded-circle bg-light-primary me-3">
                                            <i class="ki-duotone ki-calendar-add fs-4 text-primary">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span
                                                class="text-gray-600 fw-semibold d-block fs-7">{{ t('Start Date') }}</span>
                                            <span class="text-gray-900 fw-bold fs-6">
                                                {{ $item_model->start_date ? $item_model->start_date->format('M d, Y') : t('Not Set') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Planned End Date -->
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="d-flex align-items-center justify-content-center w-35px h-35px rounded-circle bg-light-primary me-3">
                                            <i class="ki-duotone ki-calendar-tick fs-4 text-primary">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span
                                                class="text-gray-600 fw-semibold d-block fs-7">{{ t('End Date') }}</span>
                                            <span class="text-gray-900 fw-bold fs-6">
                                                {{ $item_model->end_date ? $item_model->end_date->format('M d, Y') : t('Not Set') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Planned Duration -->
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="d-flex align-items-center justify-content-center w-35px h-35px rounded-circle bg-light-primary me-3">
                                            <i class="ki-duotone ki-timer fs-4 text-primary">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span
                                                class="text-gray-600 fw-semibold d-block fs-7">{{ t('Planned Duration') }}</span>
                                            <span class="text-gray-900 fw-bold fs-6">
                                                @if ($item_model->start_date && $item_model->end_date)
                                                    {{ $item_model->start_date->diffInDays($item_model->end_date) + 1 }}
                                                    {{ t('days') }}
                                                @else
                                                    {{ t('Not Set') }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actual Timeline Card -->
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header min-h-50px">
                                <h3 class="card-title fw-bold text-dark d-flex align-items-center">
                                    <i class="ki-duotone ki-calendar-tick fs-2 text-success me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    {{ t('Actual Timeline') }}
                                </h3>
                            </div>
                            <div class="card-body p-5">
                                <div class="d-flex flex-column gap-5">
                                    <!-- Actual Start -->
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="d-flex align-items-center justify-content-center w-35px h-35px rounded-circle bg-light-success me-3">
                                            <i class="ki-duotone ki-calendar-add fs-4 text-success">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span
                                                class="text-gray-600 fw-semibold d-block fs-7">{{ t('Actual Start') }}</span>
                                            <div class="d-flex align-items-center">
                                                <span class="text-gray-900 fw-bold fs-6 me-2">
                                                    @if ($item_model->actual_start_date)
                                                        {{ Carbon\Carbon::parse($item_model->actual_start_date)->format('M d, Y') }}
                                                    @else
                                                        {{ t('Not Started') }}
                                                    @endif
                                                </span>
                                                @if ($item_model->actual_start_date)
                                                    <span class="badge badge-light-success">{{ t('Started') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actual End -->
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="d-flex align-items-center justify-content-center w-35px h-35px rounded-circle bg-light-success me-3">
                                            <i class="ki-duotone ki-calendar-tick fs-4 text-success">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span
                                                class="text-gray-600 fw-semibold d-block fs-7">{{ t('Actual End') }}</span>
                                            <div class="d-flex align-items-center">
                                                <span class="text-gray-900 fw-bold fs-6 me-2">
                                                    @if ($item_model->actual_end_date)
                                                        {{ Carbon\Carbon::parse($item_model->actual_end_date)->format('M d, Y') }}
                                                    @else
                                                        {{ t('In Progress') }}
                                                    @endif
                                                </span>
                                                @if ($item_model->actual_end_date)
                                                    <span
                                                        class="badge badge-light-success">{{ t('Completed') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actual Duration -->
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="d-flex align-items-center justify-content-center w-35px h-35px rounded-circle bg-light-success me-3">
                                            <i class="ki-duotone ki-timer fs-4 text-success">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span
                                                class="text-gray-600 fw-semibold d-block fs-7">{{ t('Actual Duration') }}</span>
                                            <div class="d-flex align-items-center">
                                                <span class="text-gray-900 fw-bold fs-6 me-2">
                                                    @if ($item_model->actual_days)
                                                        {{ $item_model->actual_days }} {{ t('days') }}
                                                    @else
                                                        {{ t('Calculating...') }}
                                                    @endif
                                                </span>
                                                @if ($item_model->actual_days && $item_model->start_date && $item_model->end_date)
                                                    @php
                                                        $plannedDays =
                                                            $item_model->start_date->diffInDays($item_model->end_date) +
                                                            1;
                                                        $diff = $item_model->actual_days - $plannedDays;
                                                    @endphp
                                                    <span
                                                        class="badge badge-{{ $diff <= 0 ? 'light-success' : 'light-warning' }}">
                                                        {{ $diff == 0 ? t('On Time') : ($diff < 0 ? t('Early') : t('Delayed')) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attachments Section -->
            <div class="separator separator-dashed my-8"></div>
            <div class="px-2">
                <h3 class="fs-4 fw-bold d-flex align-items-center mb-6">
                    <i class="ki-duotone ki-folder fs-3 me-2 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    {{ t('Attachments') }}
                </h3>

                <div class="row g-5">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body p-0">
                                @if ($item_model->attachments->count() > 0)
                                    <div class="px-5 py-3">
                                        <div class="d-flex flex-column gap-3">
                                            @foreach ($item_model->attachments as $attachment)
                                                <div class="d-flex align-items-center p-3 bg-light-primary rounded">
                                                    <!-- File Icon based on type -->
                                                    <div
                                                        class="d-flex align-items-center justify-content-center w-40px h-40px rounded-circle bg-primary me-3">
                                                        <i class="ki-duotone ki-file fs-2 text-white">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </div>

                                                    <!-- File Details -->
                                                    <div class="d-flex flex-column flex-grow-1">
                                                        <span
                                                            class="text-gray-800 fw-bold fs-6 mb-0">{{ $attachment->file_name }}</span>
                                                        <span class="text-gray-400 fs-7">
                                                            {{ \Carbon\Carbon::parse($attachment->created_at)->format('M d, Y H:i') }}
                                                        </span>
                                                    </div>

                                                    <!-- Download Button -->
                                                    <a href="{{ asset($attachment->file_path) }}"
                                                        class="btn btn-sm btn-icon btn-primary" target="_blank"
                                                        title="{{ t('Download') }}">
                                                        <i class="ki-duotone ki-arrow-down fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-10">
                                        <i class="ki-duotone ki-document fs-3x text-gray-400 mb-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <div class="text-gray-600 fs-6">{{ t('No attachments found') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Task Process Timeline -->
            <div class="separator separator-dashed my-8"></div>
            <!-- Comments Section -->
            <div class="card shadow-sm mt-5">
                <div class="card-header">
                    <h3 class="card-title fw-bold text-dark">{{ t('Comments') }}</h3>
                </div>
                <div class="card-body">
                    <!-- Comment Form -->
                    <form id="taskCommentForm" class="mb-8">
                        <input type="hidden" id="task_assignment_id" value="{{ $item_model->id }}">

                        <!-- Comment Editor -->
                        <div id="taskCommentEditor" style="height: 200px;" class="mb-5"></div>

                        <!-- File Upload Zone -->
                        <div class="dropzone mb-5" id="taskCommentDropzone">
                            <div class="dz-message needsclick">
                                <i class="ki-duotone ki-file-up fs-3x text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <div class="ms-4">
                                    <h3 class="fs-5 fw-bold text-gray-900">
                                        {{ t('Drop files here or click to upload') }}
                                    </h3>
                                    <span
                                        class="fs-7 fw-semibold text-gray-400">{{ t('Upload up to 10 files') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary" id="submitComment">
                                <span class="indicator-label">
                                    <i class="ki-duotone ki-send-up fs-2 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    {{ t('Post Comment') }}
                                </span>
                                <span class="indicator-progress">
                                    {{ t('Please wait...') }}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>

                    <!-- Comments List -->
                    <div id="taskCommentsList" class="mt-5"></div>
                </div>
            </div>

        </div>
        <div class="card shadow-none border-0">
            <!-- Task Process Timeline -->
            <div class="separator separator-dashed my-8"></div>

            <div class="px-2">
                <h3 class="fs-4 fw-bold mb-6">{{ t('Task Process Timeline') }}</h3>
                <div class="tsk-timeline">
                    @foreach ($task_processes as $process)
                        <div class="tsk-timeline-item" onclick="openProcessComments({{ $process->id }})">
                            <div class="tsk-timeline-avatar">
                                {{ substr($process->user->name ?? 'U', 0, 1) }}
                            </div>

                            <div class="tsk-timeline-content">
                                <div class="tsk-timeline-header">
                                    <span class="tsk-timeline-user">{{ $process->user->name }}</span>
                                    <span class="tsk-timeline-time">{{ $process->created_at->diffForHumans() }}</span>
                                </div>

                                @if ($process->type->constant_name === 'status_change')
                                    <div class="tsk-timeline-status">
                                        <div class="tsk-status-change">
                                            <span class="tsk-status-label">{{ $process->old_value }}</span>
                                            <span class="tsk-status-arrow">
                                                <i class="ki-duotone ki-arrow-right fs-6"></i>
                                            </span>
                                            <span
                                                class="tsk-status-label tsk-status-{{ strtolower($process->new_value) }}">
                                                {{ $process->new_value }}
                                            </span>
                                        </div>
                                        <span class="text-muted">({{ t('Status') }})</span>
                                    </div>
                                @elseif ($process->type->constant_name === 'active')
                                    <div class="tsk-timeline-status">
                                        <div class="tsk-status-change">
                                            <span class="tsk-status-label">{{ $process->old_value }}</span>
                                            <span class="tsk-status-arrow">
                                                <i class="ki-duotone ki-arrow-right fs-6"></i>
                                            </span>
                                            <span
                                                class="tsk-status-label tsk-status-{{ $process->new_value ? 'completed' : 'processing' }}">
                                                {{ $process->new_value }}
                                            </span>
                                        </div>
                                        <span class="text-muted">({{ t('Active Flag') }})</span>
                                    </div>
                                @else
                                    <div class="tsk-timeline-notes">
                                        {{ $process->notes }}
                                    </div>
                                @endif

                                @if ($process->comments_count > 0)
                                    <div class="tsk-comments-indicator">
                                        <i class="ki-duotone ki-message-text-2 fs-6"></i>
                                        <span>{{ $process->comments_count }} {{ t('comments') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <div class="modal-footer border-0">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ t('Close') }}</button>
    </div>
</div>
