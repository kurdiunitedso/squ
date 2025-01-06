<?php

namespace App\Http\Controllers\PolicyOffers;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\PolicyOffer;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class PolicyOfferHistoryController extends Controller
{
    public function index(Request $request, PolicyOffer $policyOffer)
    {

        $audits = $policyOffer->audits()->with('user')->orderByDesc('created_at')->get();

        $attachmentAudits = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($policyOffer) {
            $query->where('attachable_type', PolicyOffer::class)
                ->where('attachable_id', $policyOffer->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();

        return view('policyOffers.history.index', [
            'policyOffer' => $policyOffer,
            'audits' => $audits,
            'attachmentAudits' => $attachmentAudits,
        ]);
    }
}
