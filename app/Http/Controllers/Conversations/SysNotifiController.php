<?php

namespace App\Http\Controllers\Conversations;

use App\Http\Controllers\Controller;
use App\Models\SystemNotification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SysNotifiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('conversations.system.index');
        }
        if ($request->isMethod('POST')) {
            $sysNotifications = SystemNotification::with('notifiable', 'type')
                ->select('system_notifications.*');
            return DataTables::eloquent($sysNotifications)
                ->editColumn('module', function ($smsNotifications) {
                    $senderModel = $smsNotifications->notifiable->getMorphClass();
                    $Module = class_basename($senderModel);
                    return $Module . '-' . $smsNotifications->notifiable->id;
                })
                ->editColumn('created_at', function ($sysNotification) {
                    return [
                        'display' => e(
                            $sysNotification->created_at->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $sysNotification->created_at->timestamp
                    ];
                })
                ->make();
        }
    }
}
