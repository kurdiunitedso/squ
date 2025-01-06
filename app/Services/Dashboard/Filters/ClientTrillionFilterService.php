<?php

namespace App\Services\Dashboard\Filters;

use App\Models\ClientTrillion;
use Illuminate\Support\Facades\Log;

class ClientTrillionFilterService
{
    public function applyFilters($query, $params)
    {
        Log::info("Starting to apply filters with params:", $params);

        if (!$params) return;

        foreach ($params as $key => $value) {
            if ($value !== null && $value !== '') {
                Log::info("Applying filter for: $key with value:", ['value' => $value]);
                $this->applyFilter($query, $key, $value);
            }
        }

        logQuery($query);
    }

    protected function applyFilter($query, $key, $value)
    {
        switch ($key) {
            case 'country_id':
                $this->filterByCountry($query, $value);
                break;
            case 'city_id':
                $this->filterByCity($query, $value);
                break;
            case 'company_type':
                $this->filterByCompanyType($query, $value);
                break;
            case 'has_attachments':
                $this->filterByHasAttachments($query, $value);
                break;
            case 'has_socials':
                $this->filterByHasSocials($query, $value);
                break;
            case 'has_teams':
                $this->filterByHasTeams($query, $value);
                break;
            case 'created_at':
                $this->filterByDate($query, $value);
                break;
            case 'search':
                $this->filterBySearch($query, $value);
                break;
            default:
                Log::warning("Unknown filter key: $key");
                break;
        }
    }

    private function filterByCountry($query, $value)
    {
        $ids = filterArrayForNullValues($value);
        if (count($ids) > 0) {
            $query->whereIn('country_id', $ids);
        }
    }

    private function filterByCity($query, $value)
    {
        $ids = filterArrayForNullValues($value);
        if (count($ids) > 0) {
            $query->whereIn('city_id', $ids);
        }
    }

    private function filterByCompanyType($query, $value)
    {
        $types = filterArrayForNullValues($value);
        if (count($types) > 0) {
            $query->whereIn('company_type', $types);
        }
    }

    private function filterByHasAttachments($query, $value)
    {
        if ($value === 'Yes') {
            $query->where('attachments_count', '>=', 1);
        }
    }

    private function filterByHasSocials($query, $value)
    {
        if ($value === 'Yes') {
            $query->where('socials_count', '>=', 1);
        }
    }

    private function filterByHasTeams($query, $value)
    {
        if ($value === 'Yes') {
            $query->where('teams_count', '>=', 1);
        }
    }

    private function filterByDate($query, $value)
    {
        if ($value) {
            $date = explode('to', $value);
            if (count($date) == 1) $date[1] = $date[0];
            $query->whereBetween('created_at', [$date[0], $date[1]]);
        }
    }

    private function filterBySearch($query, $value)
    {
        $query->where(function ($q) use ($value) {
            $q->orWhere('registration_number', 'like', "%$value%")
                ->orWhere('name', 'like', "%$value%")
                ->orWhere('name_en', 'like', "%$value%")
                ->orWhere('name_h', 'like', "%$value%")
                ->orWhere('registration_name', 'like', "%$value%")
                ->orWhere('telephone', 'like', "%$value%")
                ->orWhere('id', 'like', "%$value%");
        });
    }
}
