<?php

namespace App\Services\Dashboard\Filters;

use Illuminate\Support\Facades\Log;

class ContractItemFilterService
{
    /**
     * Applies all available filters to the query based on params.
     */
    public function applyFilters($query, $params)
    {
        Log::info("Starting to apply filters", ['params' => $params]);

        foreach ($params as $key => $value) {
            if ($value !== null) {
                Log::info("Applying filter", ['key' => $key, 'value' => $value]);
                $this->applyFilter($query, $key, $value);
            } else {
                Log::info("Skipping filter due to null value", ['key' => $key]);
            }
        }

        Log::info("All filters applied, logging final query");
        logQuery($query);  // Using the global logQuery function

        return $query;
    }

    /**
     * Applies the filter based on the key provided.
     */
    protected function applyFilter($query, $key, $value)
    {
        Log::info("Applying specific filter", ['key' => $key]);

        switch ($key) {
            case 'search':
                $this->filterBySearch($query, $value);
                break;
                // case 'client_name':
                //     $this->filterByClientName($query, $value);
                //     break;
            default:
                Log::warning("Unknown filter key", ['key' => $key]);
                break;
        }

        Log::info("Filter applied", ['key' => $key]);
    }


    /**
     * Filters the query by search term.
     */
    private function filterBySearch($query, $value)
    {
        Log::info("Starting filterBySearch", ['value' => $value]);

        $query->where(function ($q) use ($value) {
            $q->where('notes', 'like', "%$value%")
                ->orWhereHas('item', function ($subQ) use ($value) {
                    $subQ->where('description', 'like', "%$value%");
                });
        });

        Log::info("Applied search filter to query");
        logQuery($query);
    }
}
