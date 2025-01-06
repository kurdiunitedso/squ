<?php

namespace App\Http\Controllers\SMS;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Models\Captin;
use App\Models\ShortMessage;
use App\Models\SystemSmsNotification;
use Auth;
use Illuminate\Http\Request;

class CaptinSMSController extends Controller
{
    public function view_captins_sms(Request $request, Captin $captin)
    {
        $captinSms = ShortMessage::where('captin_id', $captin->id)->with('type')
            ->orderBy('created_at', 'desc')->get();

        $smsDrawerView = view('sms.captin_shortMessages', ['SmsMessages' => $captinSms])->render();

        return response()->json(['drawerView' => $smsDrawerView, 'captinName' => 'Captin SMS - ' . $captin->name]);
    }

    public function create(Request $request, Captin $captin)
    {
        $SHORT_MESSAGE_TYPES = Constant::where('field', DropDownFields::SHORT_MESSAGE)->where('module', Modules::main_module)->get();
        $SHORT_MESSAGE_TEMPLATE = Constant::where('field', DropDownFields::SHORT_MESSAGE_TEMPLATE)->where('module', Modules::main_module)->get();
        $createView = view('sms.addedit_modal', [
            'captin' => $captin,
            'callTask' => $captin,
            'SHORT_MESSAGE_TYPES' => $SHORT_MESSAGE_TYPES,
            'SHORT_MESSAGE_TEMPLATE' => $SHORT_MESSAGE_TEMPLATE
        ])->render();
        return response()->json(['createView' => $createView]);
    }


    public function store(Request $request, Captin $captin)
    {
        $request->validate([
            'type_id' => 'required',
            'to' => 'required|max:15',
            'channel' => 'required',
            'text' => 'required|string',
        ]);

        // Implement sending sms
        $newSMS = new ShortMessage();

        $newSMS->type_id = $request->type_id;
        $newSMS->captin_id = $captin->id;
        $newSMS->to = $request->to;
        $newSMS->text = $request->text;
        $newSMS->save();

        $sms = new SystemSmsNotification();
        $sms->gateWay = 'Wheels';
        $sms->message = $request->text;
        $sms->mobile = $request->to;;
        $sms->channel = $request->channel;;
        $sms->module = 'Captin';
        $sms->type_id = $request->type_id;
        $sms->sender_type = $request->type_id;
        $sms->sender_id = $captin->id;
        $sms->sms_count = strlen($request->text) / 52;
        $sms->module_id = $captin->id;
        $sms->save();

        // if ($sms->channel == "WhatsApp")
        //$this->sendWhatsapp($sms->to, $sms->message, 'graph', 'Tabibfind', 'Tabibfind');
        /*   else
               smsapi()->gateway('Wheels')->sendMessage($newSMS->to,  $newSMS->text );*/

        return response()->json(['status' => true, 'message' => 'SMS has been Sent successfully!']);
    }
}
