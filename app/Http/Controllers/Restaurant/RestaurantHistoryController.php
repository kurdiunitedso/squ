<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Client;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class RestaurantHistoryController extends Controller
{
    public function index(Request $request, Client $client)
    {

        $audits = $client->audits()->with('user')->orderByDesc('created_at')->get();

        $attachmentAudits = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($client) {
            $query->where('attachable_type', Client::class)
                ->where('attachable_id', $client->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();

        return view('clients.history.index', [
            'client' => $client,
            'audits' => $audits,
            'attachmentAudits' => $attachmentAudits,
        ]);
    }
}
