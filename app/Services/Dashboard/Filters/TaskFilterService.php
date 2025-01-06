<?php

namespace App\Services\Dashboard\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TaskFilterService
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $query): Builder
    {
        return $query->tap(function ($query) {
            $this->applyProjectFilter($query)
                ->applyEmployeeFilter($query)
                ->applyDateFilter($query)
                ->applyActiveFilter($query)
                ->applySearchFilter($query);
        });
    }

    protected function applyProjectFilter($query): self
    {
        if ($this->request->has('project_id')) {
            $query->whereHas('task', function ($q) {
                $q->whereIn('project_id', (array)$this->request->project_id);
            });
        }

        return $this;
    }

    protected function applyEmployeeFilter($query): self
    {
        if ($this->request->has('employee_id')) {
            $query->whereIn('employee_id', (array)$this->request->employee_id);
        }

        return $this;
    }

    protected function applyDateFilter($query): self
    {
        if ($this->request->has('work_date')) {
            $dates = explode(' to ', $this->request->work_date);
            if (count($dates) == 2) {
                $query->where(function ($q) use ($dates) {
                    $q->whereBetween('start_date', $dates)
                        ->orWhereBetween('end_date', $dates);
                });
            }
        }

        return $this;
    }

    protected function applyActiveFilter($query): self
    {
        if ($this->request->has('is_active')) {
            $query->where('active', $this->request->is_active === 'YES');
        }

        return $this;
    }

    protected function applySearchFilter($query): self
    {
        if ($this->request->has('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                // Direct task assignment fields
                $q->where(function ($subQ) use ($search) {
                    $subQ->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });

                // Related entities search
                $q->orWhereHas('task.project', function ($projectQ) use ($search) {
                    // Search in project's client
                    $projectQ->whereHas('contract.client_trillion', function ($clientQ) use ($search) {
                        $clientQ->where(function ($nameQ) use ($search) {
                            $nameQ->where('name', 'like', "%{$search}%")
                                ->orWhere('name_en', 'like', "%{$search}%")
                                ->orWhere('name_h', 'like', "%{$search}%");
                        });
                    });

                    // Search in project's items
                    $projectQ->orWhereHas('item', function ($itemQ) use ($search) {
                        $itemQ->where('description', 'like', "%{$search}%");
                    });
                });
            });
        }

        return $this;
    }
}
