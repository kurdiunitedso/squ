{{-- resources/views/tasks/partials/_board.blade.php --}}
@foreach ($status_list as $status)
    <div class="list tsk-list">
        <div class="list-header tsk-list-header">
            <div class="tsk-list-header-title">
                {{ $status->name }}
                <span class="badge tsk-status-badge">{{ ($tasks_assigned[$status->id] ?? collect())->count() }}</span>
            </div>
        </div>
        <div class="list-cards tsk-list-cards" id="{{ $status->value }}" data-status-id="{{ $status->id }}">
            @if (isset($tasks_assigned[$status->id]))
                @foreach ($tasks_assigned[$status->id] as $task_assigned)
                    <div class="card task-card tsk-card" data-id="{{ $task_assigned->id }}"
                        data-current-status-id="{{ $status->id }}" data-employee-id="{{ $task_assigned->employee_id }}"
                        style="--status-color: {{ $status->color }}">

                        <!-- Project Info -->
                        <div class="tsk-card-project">
                            <i class="ki-duotone ki-briefcase fs-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <div class="tsk-project-details">
                                {{-- <div class="tsk-project-name">{{ $task_assigned->task->project->name ?? 'N/A' }}</div> --}}
                                <div class="tsk-project-client">
                                    {{ $task_assigned->task->project->contract_item->contract->client_trillion->name ?? 'N/A' }}
                                    -
                                    {{ $task_assigned->task->project->contract_item->item->description ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        <!-- Status and Active Badges -->
                        <div class="tsk-card-badges">
                            <span class="tsk-card-status"
                                style="background-color: {{ $status->color }}15; color: {{ $status->color }}">
                                <i class="fas fa-circle fs-8"></i>
                                {{ $status->name }}
                            </span>
                            <span class="tsk-card-active-flag {{ $task_assigned->active ? 'active' : 'inactive' }}">
                                <i
                                    class="fas {{ $task_assigned->active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                {{ $task_assigned->active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <!-- Task Info -->
                        <div class="tsk-card-title">{{ $task_assigned->title }}</div>
                        <div class="tsk-card-description">
                            {{ Str::limit($task_assigned->description, 50) }}
                        </div>

                        <!-- Employee Info -->
                        <div class="tsk-card-employee">
                            <div class="tsk-employee-avatar">
                                {{ substr($task_assigned->employee->name ?? 'U', 0, 1) }}
                            </div>
                            <div class="tsk-employee-info">
                                <span
                                    class="tsk-employee-name">{{ $task_assigned->employee->name ?? 'Unassigned' }}</span>
                                <span class="tsk-employee-position">
                                    @php
                                        $projectEmployee = $task_assigned->task->project->projectEmployees
                                            ->where('employee_id', $task_assigned->employee_id)
                                            ->first();
                                    @endphp
                                    {{ $projectEmployee?->position?->name ?? 'No Position' }}
                                </span>
                            </div>
                        </div>

                        <!-- Dates and Actions -->
                        <div class="tsk-card-meta">
                            <div class="tsk-card-dates">
                                <div class="tsk-meta-item">
                                    <i class="ki-duotone ki-calendar">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span>{{ $task_assigned->start_date?->format('M d, Y') ?? 'No start date' }}</span>
                                </div>
                                @if ($task_assigned->end_date)
                                    <div class="tsk-meta-item">
                                        <i class="ki-duotone ki-calendar-tick">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <span>Due: {{ $task_assigned->end_date->format('M d, Y') }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="tsk-card-actions">
                                <button type="button" class="btn btn-sm btn-light-primary view-timeline-btn"
                                    data-task-id="{{ $task_assigned->task->id }}"
                                    data-task-title="{{ $task_assigned->task->title }}">
                                    <i class="fas fa-stream"></i>
                                    {{ t('View Timeline') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endforeach
