<?php

namespace App\Services\Dashboard\Filters;

use Illuminate\Support\Facades\Log;

class ProjectFilterService
{
    /**
     * Applies all available filters to the query based on params.
     */
    public function applyFilters($query, $params)
    {
        Log::info("Starting to apply filters with params:", $params);
        $user = auth()->user();
        $query->when($user->hasRole('Art Manager'), function ($q) use ($user) {
            // dd(435);
            $q->where(['art_manager_id' => $user->employee->id]);
        });
        foreach ($params as $key => $value) {
            if ($value !== null) {
                Log::info("Applying filter for: $key with value:", ['value' => $value]);

                $this->applyFilter($query, $key, $value);
            } else {
                Log::info("Skipping filter for: $key as the value is null.");
            }
        }

        // Log the final SQL query and its bindings.
        $this->logQuery($query);

        Log::info("All filters applied.");
    }

    /**
     * Applies the filter based on the key provided.
     */
    protected function applyFilter($query, $key, $value)
    {
        switch ($key) {
            case 'search':
                $this->filterBySearch($query, $value);
                break;

            case 'client_name':
                $this->filterByClientName($query, $value);
                break;

            default:
                Log::warning("Unknown filter key: $key");
                break;
        }
    }

    /**
     * Logs the query and its bindings.
     */
    protected function logQuery($query)
    {
        Log::info('Final SQL query:', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);

        // Construct the full SQL query with bindings replaced.
        $fullQuery = vsprintf(
            str_replace('?', "'%s'", $query->toSql()),
            collect($query->getBindings())->map(fn($binding) => is_numeric($binding) ? $binding : addslashes($binding))->toArray()
        );
        Log::info('Final SQL query with bindings replaced: ' . $fullQuery);
    }





    /**
     * Filters the query by client name.
     */
    private function filterByClientName($query, $value)
    {
        $clientNames = filterArrayForNullValues($value);
        Log::info('Filtering by client name with values:', ['clientNames' => $clientNames]);


        $locales = config('app.locales');
        Log::info('Locales fetched from config:', $locales);

        if (count($clientNames) > 0) {

            Log::info('Filter by client name applied.');
        } else {
            Log::info('No valid client names to filter.');
        }
    }





    /**
     * Filters the query by search term.
     */
    private function filterBySearch($query, $value)
    {
        Log::info("Starting filterBySearch with value: " . $value);
        $query
            ->where(function ($q) use ($value) {
                $q->where('objectives', 'like', "%$value%");
            })
            ->orWhereHas('contract', function ($q) use ($value) {
                $q->whereHas('client_trillion', function ($q2) use ($value) {
                    $q2->where('name', 'like', "%$value%")->orWhere('name_en', 'like', "%$value%");
                });
            })
            ->orWhereHas('item', function ($q) use ($value) {
                $q->where('description', 'like', "%$value%");
            })
            ->orWhereHas('project_type', function ($q) use ($value) {
                $q->where('name', 'like', "%$value%");
            })
            ->orWhereHas('account_manager', function ($q) use ($value) {
                $q->where('name', 'like', "%$value%")
                    // ->orWhere('name_en', 'like', "%$value%")
                ;
            })
            ->orWhereHas('art_manager', function ($q) use ($value) {
                $q->where('name', 'like', "%$value%")
                    // ->orWhere('name_en', 'like', "%$value%")
                ;
            })
        ;
    }
}
