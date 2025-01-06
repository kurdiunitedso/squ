<?php

namespace App\Services\Dashboard\Filters;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TaskAssignmentFilterService
{
    /**
     * Applies all task board filters
     */
    public function applyTaskBoardFilters($query, $filters)
    {
        Log::info("Starting to apply task board filters", [
            'original_filters' => $filters,
            'query_type' => get_class($query)
        ]);

        if (!empty($filters)) {
            // Filter and clean the filters array
            $cleanedFilters = $this->cleanFilters($filters);
            Log::info("Cleaned filters:", ['cleaned_filters' => $cleanedFilters]);

            foreach ($cleanedFilters as $key => $value) {
                Log::info("Processing filter", ['key' => $key, 'value' => $value]);
                $this->applyFilter($query, $key, $value);
            }
        } else {
            Log::info("No filters to apply");
        }

        return $query;
    }

    /**
     * Clean and prepare filters
     */
    protected function cleanFilters($filters)
    {
        Log::info("Starting to clean filters", ['input_filters' => $filters]);

        $cleanedFilters = [];

        foreach ($filters as $key => $value) {
            Log::info("Cleaning filter", ['key' => $key, 'original_value' => $value]);

            switch ($key) {
                case 'status_id':
                    $cleanedValue = filterArrayForNullValues($value);
                    if (!empty($cleanedValue)) {
                        $cleanedFilters[$key] = $cleanedValue;
                    }
                    break;

                case 'work_date':
                    if (!empty($value)) {
                        $cleanedFilters[$key] = $value;
                    }
                    break;

                case 'is_active':
                    if ($value !== null && $value !== '') {
                        $cleanedFilters[$key] = $value;
                    }
                    break;

                case 'search':
                    if (!empty(trim($value))) {
                        $cleanedFilters[$key] = trim($value);
                    }
                    break;

                default:
                    Log::warning("Unknown filter key encountered", ['key' => $key]);
                    break;
            }

            Log::info("Filter cleaning result", [
                'key' => $key,
                'original_value' => $value,
                'cleaned_value' => $cleanedFilters[$key] ?? null
            ]);
        }

        return $cleanedFilters;
    }

    /**
     * Apply individual filter based on key
     */
    protected function applyFilter($query, $key, $value)
    {
        Log::info("Applying individual filter", [
            'key' => $key,
            'value' => $value,
            'query_class' => get_class($query)
        ]);

        switch ($key) {
            case 'search':
                $this->filterBySearch($query, $value);
                break;

            case 'status_id':
                $this->filterByStatus($query, $value);
                break;

            case 'is_active':
                $this->filterByActive($query, $value);
                break;

            case 'work_date':
                $this->filterByWorkDate($query, $value);
                break;

            default:
                Log::warning("Unknown filter key in applyFilter", ['key' => $key]);
                break;
        }
    }

    /**
     * Filter by search term
     */
    protected function filterBySearch($query, $searchTerm)
    {
        Log::info("Starting search filter", ['search_term' => $searchTerm]);

        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%");

            Log::info("Applied search conditions", [
                'title_condition' => "%{$searchTerm}%",
                'description_condition' => "%{$searchTerm}%"
            ]);
        });
    }

    /**
     * Filter by status
     */
    protected function filterByStatus($query, $statusIds)
    {
        Log::info("Starting status filter", ['initial_status_ids' => $statusIds]);

        $cleanedStatusIds = filterArrayForNullValues($statusIds);
        Log::info("Cleaned status IDs", ['cleaned_status_ids' => $cleanedStatusIds]);

        if (!empty($cleanedStatusIds)) {
            $query->whereIn('status_id', $cleanedStatusIds);
            Log::info("Applied status filter", ['final_status_ids' => $cleanedStatusIds]);
        } else {
            Log::warning("No valid status IDs after cleaning");
        }
    }

    /**
     * Filter by active status
     */
    protected function filterByActive($query, $isActive)
    {
        Log::info("Starting active status filter", ['is_active_input' => $isActive]);

        $activeValue = ($isActive === 'YES');
        $query->where('active', $activeValue);

        Log::info("Applied active filter", [
            'original_value' => $isActive,
            'converted_value' => $activeValue
        ]);
    }

    /**
     * Filter by work date range
     */
    protected function filterByWorkDate($query, $dateRange)
    {
        Log::info("Starting work date filter", ['date_range' => $dateRange]);

        $dates = explode(' to ', $dateRange);
        Log::info("Split date range", ['dates' => $dates]);

        if (count($dates) === 2) {
            try {
                $startDate = Carbon::parse($dates[0])->startOfDay();
                $endDate = Carbon::parse($dates[1])->endOfDay();

                Log::info("Parsed dates", [
                    'start_date' => $startDate->toDateTimeString(),
                    'end_date' => $endDate->toDateTimeString()
                ]);

                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate])
                        ->orWhere(function ($subQ) use ($startDate, $endDate) {
                            $subQ->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $endDate);
                        });

                    Log::info("Applied date range conditions", [
                        'date_conditions' => [
                            'start_date_between' => [$startDate, $endDate],
                            'end_date_between' => [$startDate, $endDate],
                            'spanning_dates' => [
                                'start_date_lte' => $startDate,
                                'end_date_gte' => $endDate
                            ]
                        ]
                    ]);
                });
            } catch (\Exception $e) {
                Log::error("Error processing date range", [
                    'error' => $e->getMessage(),
                    'dates' => $dates
                ]);
            }
        } else {
            Log::warning("Invalid date range format", ['date_range' => $dateRange]);
        }
    }

    /**
     * Log the final query for debugging
     */
    public function logQuery($query)
    {
        Log::info('Starting query logging');

        $sql = $query->toSql();
        $bindings = $query->getBindings();

        Log::info('Query details:', [
            'raw_sql' => $sql,
            'bindings' => $bindings
        ]);

        $fullQuery = vsprintf(
            str_replace('?', "'%s'", $sql),
            collect($bindings)
                ->map(
                    fn($binding) =>
                    $binding instanceof Carbon
                        ? $binding->format('Y-m-d H:i:s')
                        : (is_numeric($binding) ? $binding : addslashes($binding))
                )->toArray()
        );

        Log::info('Final compiled SQL query:', ['query' => $fullQuery]);
    }
}
