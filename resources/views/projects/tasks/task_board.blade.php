@foreach ($projectEmployees as $employeeData)
    @php
        // dd($employeeData);
        $employee = $employeeData['employee'];
        $position = $employeeData['position'];
        $tasks_assigned = $employeeData['tasks_assigned'];
    @endphp
    <div class="task-list">
        <div class="task-list-header">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="task-list-title">{{ $employee->name }}</span>
                    @if ($position)
                        <span class="task-list-position">{{ $position->name }}</span>
                    @endif
                </div>
                <span class="task-list-count">{{ $tasks_assigned->count() }}</span>
            </div>
        </div>

        <div class="task-list-cards" id="{{ $employee->id }}">
            @foreach ($tasks_assigned as $task_assigned)
                <div class="task-card" data-task-assignment-id="{{ $task_assigned->id }}"
                    data-task-id="{{ $task_assigned->task_id }}">
                    <div class="task-card-badges">
                        <span class="task-card-status"
                            style="background-color: {{ $task_assigned->status->color }}15;
                                     color: {{ $task_assigned->status->color }};">
                            <i class="fas fa-circle"></i>
                            {{ $task_assigned->status->name }}
                        </span>
                        <span class="task-active-badge {{ $task_assigned->active ? 'active' : 'inactive' }}">
                            <i class="fas {{ $task_assigned->active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                            {{ $task_assigned->active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="task-card-title">{{ $task_assigned->title }}</div>
                    <div class="task-card-description">
                        {{ Str::limit($task_assigned->description, 50) }}
                    </div>
                    <div class="task-card-meta">
                        <div class="task-card-dates">
                            <i class="fas fa-calendar-alt"></i>
                            <span>
                                {{ $task_assigned->start_date ? 'Start: ' . $task_assigned->start_date->format('Y-m-d') : 'No start date' }}
                            </span>
                            <span>
                                {{ $task_assigned->end_date ? 'End: ' . $task_assigned->end_date->format('Y-m-d') : 'No end date' }}
                            </span>
                        </div>
                        @if ($task_assigned->actual_days)
                            <div class="task-card-duration">
                                <i class="fas fa-clock"></i>
                                {{ $task_assigned->actual_days }} days
                            </div>
                        @endif
                    </div>
                    <div class="task-card-actions mt-2">
                        <button type="button" class="btn btn-sm btn-light-primary view-timeline-btn"
                            data-task-id="{{ $task_assigned->task->id }}"
                            data-task-title="{{ $task_assigned->task->title }}">
                            <i class="fas fa-stream"></i>
                            {{ t('View Timeline') }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach
