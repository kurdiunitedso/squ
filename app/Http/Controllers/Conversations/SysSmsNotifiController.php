<?php

namespace App\Http\Controllers\Conversations;

use App\Http\Controllers\Controller;
use App\Models\SystemSmsNotification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SysSmsNotifiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('conversations.sms.index');
        }
        if ($request->isMethod('POST')) {
            $smsNotifications = SystemSmsNotification::with('sender', 'type')
                ->select('system_sms_notifications.*');
            return DataTables::eloquent($smsNotifications)
                ->editColumn('module', function ($smsNotifications) {
                    $senderModel = $smsNotifications->sender->getMorphClass();
                    $Module = class_basename($senderModel);
                    return $Module . '-' . $smsNotifications->sender->id;
                })
                ->editColumn('created_at', function ($smsNotification) {
                    return [
                        'display' => e(
                            $smsNotification->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $smsNotification->created_at->timestamp
                    ];
                })
                ->make();
        }
    }
}
