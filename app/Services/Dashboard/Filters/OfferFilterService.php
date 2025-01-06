<?php

namespace App\Services\Dashboard\Filters;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Builder;

class OfferFilterService
{
    /**
     * Apply filters to the offers query
     */
    public function apply(Builder $query, array $searchParams = []): Builder
    {
        if (empty($searchParams)) {
            return $query;
        }

        return $this->applyFilters($query, $searchParams);
    }

    /**
     * Apply individual filters based on search parameters
     */
    private function applyFilters(Builder $query, array $params): Builder
    {
        // Facility Filter
        if (isset($params['facility_id'])) {
            $facilityIds = $this->filterNullValues($params['facility_id']);
            if (!empty($facilityIds)) {
                $query->whereIn('facility_id', $facilityIds);
            }
        }

        // Type Filter
        if (isset($params['type_id'])) {
            $typeIds = $this->filterNullValues($params['type_id']);
            if (!empty($typeIds)) {
                $query->whereIn('type_id', $typeIds);
            }
        }

        // Active Status Filter
        if (isset($params['is_active'])) {
            $status = $params['is_active'] === "YES" ? 1 : 0;
            $query->where('active', $status);
        }

        // Date Range Filter
        if (isset($params['created_at'])) {
            $dateRange = $this->parseDateRange($params['created_at']);
            $query->whereBetween('created_at', $dateRange);
        }

        // Search Filter
        if (isset($params['search'])) {
            $searchTerm = $params['search'];
            $query->whereHas('facility', function ($q) use ($searchTerm) {
                $q->where('contact_person', 'like', "%{$searchTerm}%")
                    ->orWhere('contact_social', 'like', "%{$searchTerm}%")
                    ->orWhere('telephone', 'like', "%{$searchTerm}%");
            });
        }

        return $query;
    }

    /**
     * Filter out null values from array
     */
    private function filterNullValues(array $values): array
    {
        return array_filter($values, fn($value) => !is_null($value));
    }

    /**
     * Parse date range from string
     */
    private function parseDateRange(string $dateString): array
    {
        $dates = explode('to', $dateString);
        return [
            $dates[0],
            $dates[1] ?? $dates[0]
        ];
    }
}
