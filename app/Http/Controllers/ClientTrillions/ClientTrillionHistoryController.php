<?php

namespace App\Http\Controllers\ClientTrillions;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\ClientTrillion;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class ClientTrillionHistoryController extends Controller
{
    public function index(Request $request, ClientTrillion $clientTrillion)
    {

        $audits = $clientTrillion->audits()->with('user')->orderByDesc('created_at')->get();

        $attachmentAudits = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($clientTrillion) {
            $query->where('attachable_type', ClientTrillion::class)
                ->where('attachable_id', $clientTrillion->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();

        return view('clientTrillions.history.index', [
            'clientTrillion' => $clientTrillion,
            'audits' => $audits,
            'attachmentAudits' => $attachmentAudits,
        ]);
    }
}
