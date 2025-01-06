<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromView, WithStyles
{


    private $branch_id;
    private $role_id;
    private $created_at;
    private $is_active;
    private $search_name;
    function __construct(
        $search_name,
        $branch_id,
        $role_id,
        $created_at,
        $is_active,
    ) {
        $this->search_name = $search_name;
        $this->branch_id = $branch_id;
        $this->role_id = $role_id;
        $this->created_at = $created_at;
        $this->is_active = $is_active;
    }


    public function view(): View
    {
        //
        $search_name = $this->search_name;
        $branch_id = $this->branch_id;
        $role_id = $this->role_id;
        $created_at = $this->created_at;
        $is_active = $this->is_active;

        $query =  User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'super-admin');
        })->with(['roles', 'branch']);

        $query->where(function ($q) use ($search_name) {
            $q->where('name', 'like', "%" . $search_name . "%");
            $q->orWhere('mobile', 'like', "%" . $search_name . "%");
        });

        $query->whereHas('roles', function ($query) use ($role_id) {
            if ($role_id != null) {
                $query->where('id', $role_id);
            }
        });

        if ($branch_id && count($branch_id) > 0)
            $query->whereIn('branch_id', $branch_id);

        if ($is_active != null) {
            $status = $is_active == "YES" ? true : false;
            $query->where('status', $status);
        }

        if ($created_at != null) {
            $date = explode('to', $created_at);
            if (count($date) == 1) $date[1] = $date[0];
            $query->whereBetween('created_at', [$date[0], $date[1]]);
        }

        $users = $query->get();
        return view('user-management.users.export', [
            'users' => $users
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
