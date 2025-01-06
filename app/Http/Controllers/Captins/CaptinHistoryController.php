<?php

namespace App\Http\Controllers\Captins;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Captin;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class CaptinHistoryController extends Controller
{
    public function index(Request $request, Captin $captin)
    {

        $audits = $captin->audits()->with('user')->orderByDesc('created_at')->get();

        $attachmentAudits = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($captin) {
            $query->where('attachable_type', Captin::class)
                ->where('attachable_id', $captin->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();

        return view('captins.history.index', [
            'captin' => $captin,
            'audits' => $audits,
            'attachmentAudits' => $attachmentAudits,
        ]);
    }
}
