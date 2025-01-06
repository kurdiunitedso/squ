<?php

namespace App\Http\Controllers\Vehicles;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class VehicleHistoryController extends Controller
{
    public function index(Request $request, Vehicle $vehicle)
    {

        $audits = $vehicle->audits()->with('user')->orderByDesc('created_at')->get();

        $attachmentAudits = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($vehicle) {
            $query->where('attachable_type', Vehicle::class)
                ->where('attachable_id', $vehicle->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();

        return view('vehicles.history.index', [
            'vehicle' => $vehicle,
            'audits' => $audits,
            'attachmentAudits' => $attachmentAudits,
        ]);
    }
}
