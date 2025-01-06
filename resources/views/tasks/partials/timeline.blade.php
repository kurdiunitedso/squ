@php
    // Calculate date range and grid positions
    $minDate = $dateRange->first();
    $maxDate = $dateRange->last();
    $totalDays = $dateRange->count();
    $dayWidth = 100; // Width in pixels for each day column

    // Process assignments to calculate positions
    foreach ($assignments as $assignment) {
        $assignmentStart = Carbon\Carbon::parse($assignment->start_date)->startOfDay();
        $assignmentEnd = Carbon\Carbon::parse($assignment->end_date)->startOfDay();

        // Calculate position relative to the first date in range
        $startDiff = max(0, $assignmentStart->diffInDays($minDate));
        $duration = max(1, $assignmentStart->diffInDays($assignmentEnd) + 1);

        // Calculate position and width as percentages
        $assignment->position_left = ($startDiff / $totalDays) * 100;
        $assignment->width = ($duration / $totalDays) * 100;
    }
@endphp

<div class="workflow-container">
    <div class="timeline-header">
        <h2 class="workflow-title">Task {{ $task->id }} Workflow Timeline</h2>
        <div class="stats-container d-none"></div>
    </div>

    <!-- Timeline Navigation -->
    <div class="timeline-dates-wrapper">
        <div class="timeline-navigation">
            <div class="timeline-scroll-buttons">
                <button class="scroll-button" data-direction="left">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="scroll-button" data-direction="right">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Date Headers -->
        <div class="timeline-dates">
            @foreach ($dateRange as $date)
                <div class="date {{ $date->isToday() ? 'today' : '' }}"
                    style="width: {{ $dayWidth }}px; min-width: {{ $dayWidth }}px;">
                    <span class="date-month">{{ $date->format('M') }}</span>
                    <span class="date-day">{{ $date->format('d') }}</span>
                    <small class="date-weekday">{{ $date->format('D') }}</small>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Timeline Content -->
    <div class="timeline-content-wrapper">
        <div class="workflow-rows">
            @foreach ($assignments->groupBy('position.name') as $positionName => $positionAssignments)
                <div class="workflow-row">
                    <div class="role-name">{{ $positionName ?? 'Unassigned' }}</div>
                    <div class="timeline-content"
                        style="width: {{ $totalDays * $dayWidth }}px; min-width: {{ $totalDays * $dayWidth }}px;">
                        @foreach ($positionAssignments as $assignment)
                            <div class="timeline-item {{ $assignment->status ? strtolower($assignment->status->constant_name) : '' }}-bg clickable-assignment"
                                style="left: {{ $assignment->position_left }}%;
                                       width: {{ $assignment->width }}%;
                                       @if ($assignment->status) background-color: {{ $assignment->status->color }}15;
                                           color: {{ $assignment->status->color }};
                                           border-color: {{ $assignment->status->color }}25; @endif"
                                data-task-id="{{ $task->id }}" data-task-assignment-id="{{ $assignment->id }}"
                                title="{{ $assignment->title }} ({{ $assignment->status ? $assignment->status->name : 'No Status' }})
                                       Start: {{ Carbon\Carbon::parse($assignment->start_date)->format('M d, Y') }}
                                       End: {{ Carbon\Carbon::parse($assignment->end_date)->format('M d, Y') }}">
                                <div class="timeline-item-content">
                                    <span class="timeline-item-title">{{ $assignment->title }}</span>
                                    @if ($assignment->status)
                                        <span class="timeline-item-status">{{ $assignment->status->name }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
