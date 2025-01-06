<?php

namespace App\Http\Controllers\SMS;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Models\CallTask;
use App\Models\ShortMessageCallTask;
use Auth;
use Illuminate\Http\Request;

class CallTaskSMSController extends Controller
{
    public function view_callTasks_sms(Request $request, CallTask $callTask)
    {
        $callTaskSms = ShortMessageCallTask::where('callTask_id', $callTask->id)->with('type')
            ->orderBy('created_at', 'desc')->get();

        $smsDrawerView = view('sms_call_tasks.callTask_shortMessageCallTasks', ['SmsMessages' => $callTaskSms])->render();

        return response()->json(['drawerView' => $smsDrawerView, 'callTaskName' => 'CallTask SMS - ' . $callTask->name]);
    }

    public function create(Request $request, CallTask $callTask)
    {
        $SHORT_MESSAGE_TYPES = Constant::where('field',  DropDownFields::SHORT_MESSAGE)->where('module', Modules::main_module)->get();
        $SHORT_MESSAGE_TEMPLATE = Constant::where('field',  DropDownFields::SHORT_MESSAGE_TEMPLATE)->where('module', Modules::main_module)->get();
        $createView = view('sms_call_tasks.addedit_modal', [
            'callTask' => $callTask,
            'SHORT_MESSAGE_TYPES' => $SHORT_MESSAGE_TYPES,
            'SHORT_MESSAGE_TEMPLATE' => $SHORT_MESSAGE_TEMPLATE
        ])->render();
        return response()->json(['createView' => $createView]);
    }


    public function store(Request $request, CallTask $callTask)
    {
        $request->validate([
            'type_id' => 'required',
            'to' => 'required|max:15',
            'text' => 'required|string',
        ]);

        // Implement sending sms

        $newSMS = new ShortMessageCallTask();

        $newSMS->type_id = $request->type_id;
        $newSMS->callTask_id = $callTask->id;
        $newSMS->to = $request->to;
        $newSMS->text = $request->text;
        $newSMS->save();

        return response()->json(['status' => true, 'message' => 'SMS has been Sent successfully!']);
    }
}
