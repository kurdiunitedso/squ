// jQuery Timeline Plugin
(function ($) {
    $.fn.taskTimeline = function (options) {
        const settings = $.extend(
            {
                task: null,
                assignments: [],
                dateFormat: "MM-dd",
                container: {
                    class: "task-timeline-container",
                },
            },
            options
        );

        // Helper function to format dates
        function formatDate(date) {
            if (!date) return "";
            const d = new Date(date);
            const month = String(d.getMonth() + 1).padStart(2, "0");
            const day = String(d.getDate()).padStart(2, "0");
            return `${month}-${day}`;
        }

        // Calculate position percentage for timeline items
        function calculatePosition(date, startDate, endDate) {
            if (!date) return 0;
            const start = new Date(startDate);
            const end = new Date(endDate);
            const current = new Date(date);
            const totalDays = (end - start) / (1000 * 60 * 60 * 24);
            const daysPassed = (current - start) / (1000 * 60 * 60 * 24);
            return (daysPassed / totalDays) * 100;
        }

        // Generate timeline dates
        function generateTimelineDates(startDate, endDate) {
            const dates = [];
            let currentDate = new Date(startDate);
            while (currentDate <= endDate) {
                dates.push(new Date(currentDate));
                currentDate.setDate(currentDate.getDate() + 1);
            }
            return dates;
        }

        return this.each(function () {
            const $container = $(this);

            // Get date range from assignments
            const dates = settings.assignments
                .flatMap((a) => [a.start_date, a.end_date])
                .filter(Boolean)
                .map((d) => new Date(d));

            const startDate = new Date(Math.min(...dates));
            const endDate = new Date(Math.max(...dates));
            const timelineDates = generateTimelineDates(startDate, endDate);

            // Create timeline structure
            const $timeline = $(`
                <div class="${settings.container.class}">
                    <div class="timeline-header">
                        <h3 class="timeline-title">Task ${settings.task.id} Timeline</h3>
                    </div>
                    <div class="timeline-dates"></div>
                    <div class="timeline-rows"></div>
                </div>
            `);

            // Add dates to timeline
            const $timelineDates = $timeline.find(".timeline-dates");
            timelineDates.forEach((date) => {
                $timelineDates.append(`
                    <span class="timeline-date">${formatDate(date)}</span>
                `);
            });

            // Add assignments to timeline
            const $timelineRows = $timeline.find(".timeline-rows");
            settings.assignments.forEach((assignment) => {
                const startPos = calculatePosition(
                    assignment.start_date,
                    startDate,
                    endDate
                );
                const endPos = calculatePosition(
                    assignment.end_date || new Date(),
                    startDate,
                    endDate
                );
                const width = endPos - startPos;

                const $row = $(`
                    <div class="timeline-row">
                        <div class="timeline-role">${
                            assignment.position?.name || "Unassigned"
                        }</div>
                        <div class="timeline-bar-container">
                            <div class="timeline-bar"
                                 style="left: ${startPos}%; width: ${width}%;
                                        background-color: ${
                                            assignment.status?.color ||
                                            "#4a5568"
                                        }15;">
                                <span class="timeline-bar-title">${
                                    assignment.title || "Task Assignment"
                                }</span>
                            </div>
                        </div>
                        <div class="timeline-status"
                             style="color: ${
                                 assignment.status?.color || "#4a5568"
                             }">
                            ${assignment.status?.name || "No Status"}
                        </div>
                    </div>
                `);

                $timelineRows.append($row);
            });

            // Add the timeline to the container
            $container.empty().append($timeline);
        });
    };
})(jQuery);
