<?php

namespace App\Services\CP\Filters;

use Illuminate\Support\Facades\Log;

class ConstantFilterService
{
    public function applyFilters($query, $params)
    {
        Log::info("Starting to apply filters with params:", $params);

        foreach ($params as $key => $value) {
            if ($value !== null) {
                Log::info("Applying filter for: $key with value:", ['value' => $value]);

                switch ($key) {
                    case 'searchConstants':
                        $this->filterBySearchConstants($query, $value);
                        break;
                    case 'searchFields':
                        $this->filterBySearchFields($query, $value);
                        break;
                    case 'searchModules':
                        $this->filterBySearchModules($query, $value);
                        break;
                    default:
                        Log::warning("Unknown filter key: $key");
                        break;
                }
            } else {
                Log::info("Skipping filter for: $key as the value is null.");
            }
        }

        // Log the full SQL query with bindings after all filters are applied
        Log::info('Final SQL query:', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);

        // Log the actual query with bindings replaced
        $fullQuery = vsprintf(
            str_replace('?', "'%s'", $query->toSql()),
            collect($query->getBindings())->map(fn($binding) => is_numeric($binding) ? $binding : addslashes($binding))->toArray()
        );
        Log::info('Final SQL query with bindings replaced: ' . $fullQuery);

        Log::info("All filters applied.");
    }

    private function filterBySearchConstants($query, $value)
    {
        Log::info("Filtering by searchConstants with value: $value");

        $query->where(function ($q) use ($value) {
            $locales = config('app.locales');
            Log::info('Locales fetched from config:', $locales);

            // Search in name
            $q->where(function ($nameQuery) use ($value, $locales) {
                Log::info("Applying search for 'name' field");
                foreach ($locales as $index => $locale) {
                    Log::info("Searching 'name' in locale: $locale");
                    if ($index === 0) {
                        $nameQuery->whereRaw(
                            "json_extract(LOWER(name), \"$.$locale\") LIKE convert(? using utf8mb4) collate utf8mb4_general_ci",
                            ['%' . $value . '%']
                        );
                    } else {
                        $nameQuery->orWhereRaw(
                            "json_extract(LOWER(name), \"$.$locale\") LIKE convert(? using utf8mb4) collate utf8mb4_general_ci",
                            ['%' . $value . '%']
                        );
                    }
                }
            });

            // Search in description
            $q->orWhere(function ($descQuery) use ($value, $locales) {
                Log::info("Applying search for 'description' field");
                foreach ($locales as $index => $locale) {
                    Log::info("Searching 'description' in locale: $locale");
                    $descQuery->orWhereRaw(
                        "json_extract(LOWER(description), \"$.$locale\") LIKE convert(? using utf8mb4) collate utf8mb4_general_ci",
                        ['%' . $value . '%']
                    );
                }
            });

            // Also search in other relevant fields
            $q->orWhere('value', 'LIKE', "%$value%")
                ->orWhere('constant_name', 'LIKE', "%$value%")
                ->orWhere('module', 'LIKE', "%$value%")
                ->orWhere('field', 'LIKE', "%$value%");
        });

        Log::info("Filter by searchConstants completed.");
    }

    private function filterBySearchFields($query, $value)
    {
        Log::info("Filtering by searchFields with value: $value");

        $query->where('field', 'like', "%{$value}%");

        Log::info("Filter by searchFields applied.");
    }

    private function filterBySearchModules($query, $value)
    {
        Log::info("Filtering by searchModules with value: $value");

        $query->where('module', 'like', "%{$value}%");

        Log::info("Filter by searchModules applied.");
    }
}
