<?php

namespace App\Http\Controllers;

use App\Models\Captin;
use App\Models\ClientTrillionSocial;
use App\Models\Constant;
use App\Models\Employee;
use App\Models\Item;
use App\Models\ItemCost;
use App\Models\Restaurant;
use App\Models\SystemMailNotification;
use App\Models\SystemSmsNotification;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\WhatsappHistory;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public
    function sendWhatsapp($mobile, $msg, $type = 'graph', $token = 'Tabibfind', $instanceId = 'Tabibfind', $options = 0, $type2 = 0, $lnk = 0)
    {

        try {


            if (true) {


                if ($instanceId == "Tabibfind") {
                    $version = env('tf_version', 0);
                    $phoneID = env('tf_phoneID', 0);
                    $tokenWHGraph = env('tf_token', 0);
                } else {
                    return 111;
                }
                $template = "welcome";

                $url = "https://graph.facebook.com/$version/$phoneID/messages";
                $client = new Client(['headers' => ['Content-Type' => 'application/json', 'Authorization' => "Bearer $tokenWHGraph"]]);
                if ($type2 == 0 && !str_contains($instanceId, 'FB')) {
                    if (WhatsappHistory::checkNewChat($mobile, $instanceId))
                        $data = ["messaging_product" => "whatsapp", "to" => $mobile, "text" => ["body" => $msg]];
                    else
                        $data = ["messaging_product" => "whatsapp", "to" => $mobile, "type" => "template", "template" => ["name" => $template, "language" => ["code" => "ar"], "components" => [["type" => "body", "parameters" => [["type" => "text", "text" => $msg]]]]]];

                } else if ($type2 == "1") {

                    $sections = [["title" => "", "rows" => $options]];

                    $data = ["messaging_product" => "whatsapp", "to" => $mobile, "type" => "interactive", "interactive" => ["type" => "list", "body" => ["text" => $msg], "action" => ["button" => "اختر من القائمة", "sections" => $sections]]];

                } else if ($type2 == "2") {
                    $template = "appointment3";

                    $data = ["messaging_product" => "whatsapp", "to" => $mobile, "type" => "template", "template" => ["name" => $template, "language" => ["code" => "ar"], "components" => [["type" => "body", "parameters" => [["type" => "text", "text" => $msg]]], ["type" => "button", "sub_type" => "url", "index" => "0", "parameters" => [["type" => "text", "text" => $lnk]]]]]];
                } else if ($type2 == "3") {
                    $template = "welcome";

                    $data = ["messaging_product" => "whatsapp", "to" => $mobile, "type" => "template", "template" => ["name" => $template, "language" => ["code" => "ar"], "components" => [["type" => "body", "parameters" => [["type" => "text", "text" => $msg]]]]]];
                } else if (str_contains($instanceId, 'FB')) {

                    $data = ["recipient" => ["id" => $mobile], "messaging_type" => "RESPONSE", "message" => ["text" => $msg]];
                }
                // return $data;

            }
            $response = $client->post(
                $url,
                ['form_params' => $data]
            );


            $d = json_decode($response->getBody(), true);
            // return $d;
            if (count($d["messages"]) || str_contains($instanceId, 'FB')) {
                $w = new WhatsappHistory();
                $w->body = $msg;
                $w->fromMe = 1;
                $w->wid = str_contains($instanceId, 'FB') ? strtotime(date('Y-m-d H:i:s')) : $d["messages"][0]["id"];
                $w->isForwarded = 0;
                $w->time = strtotime(date('Y-m-d H:i:s'));
                $w->chatId = $mobile;
                $w->type = 'chat';
                $w->senderName = $instanceId;
                $w->chatName = $mobile;
                $w->instance_name = $instanceId;
                $w->metadata = json_encode($d);
                $w->save();
                return 1;
            }


            return 1;
        } catch (Exception $ex) {

            return 0;
            //return $ex->getMessage();
        }
        return 0;
    }

    function refineMobile($mobile, $code = 0)
    {
        $mobile = str_replace(' ', '', $mobile);
        $mobile = str_replace('-', '', $mobile);

        if ($code == 0) {
            $code='972';
        }

        if (strlen($mobile) == 9)
            $mobile = $code . $mobile;
        else if (strlen($mobile) == 10)
            $mobile = $code . substr($mobile, 1);
        elseif (strlen($mobile) == 14)
            $mobile = substr($mobile, 2);
        elseif (strlen($mobile) >= 12)
            $mobile = $mobile;
        else
            $mobile = 0;
        /*
                if (strlen($mobile) < 12)
                    $mobile = 0;*/

        $mobile = str_replace(' ', '', $mobile);
        $mobile = str_replace('-', '', $mobile);
        return $mobile;
    }

    public function filterArrayForNullValues($array)
    {
        $filteredArray = array_filter($array, function ($value) {
            return  $value != '' && $value != null ;
        });
        return $filteredArray;
    }
    public function filterArrayForEmailValues($array)
    {
        $filteredArray = array_filter($array, function ($value) {
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
               return $value;
            }


        });
        return $filteredArray;
    }


    public
    function sendWhatsappFile($mobile, $file, $file_name, $type = "0", $token = 'Tabibfind', $instanceId = 'Tabibfind', $caption = "", $type2 = 0)
    {
        try {

            if ($instanceId == "Tabibfind") {
                $version = env('tf_version');
                $phoneID = env('tf_phoneID');
                $tokenWHGraph = env('tf_token');
            }

            $url = "https://graph.facebook.com/$version/$phoneID/messages";
            $urll = $file;
            $client = new Client(['headers' => ['Content-Type' => 'application/json', 'Authorization' => "Bearer $tokenWHGraph"]]);

            if (str_contains($instanceId, "FB")) {
                $data = ["recipient" => ["id" => $mobile], "messaging_type" => "RESPONSE", "message" => ["attachment" => ["type" => "file", "filename" => $file_name, "payload" => ["url" => $urll, "is_reusable" => "true"]]]];
            } else if (WhatsappHistory::checkNewChat($mobile, $instanceId) && $type2 != 2)
                $data = ["messaging_product" => "whatsapp", "recipient_type" => "individual", "to" => $mobile, "type" => "document", "document" => ["caption" => $caption ? $caption : $file_name, "link" => $file, "filename" => $file_name]];
            else {
                $template = "welcome";

                $data2 = ["messaging_product" => "whatsapp", "to" => $mobile, "type" => "template", "template" => ["name" => $template, "language" => ["code" => "ar"], "components" => [["type" => "body", "parameters" => [["type" => "text", "text" => "الرجاء معاينة المرفق"]]]]]];

                $file = trim($file, 'https://crm.developon.co/');
                $template = "appointment3";

                $data = ["messaging_product" => "whatsapp", "to" => $mobile, "type" => "template", "template" => ["name" => $template, "language" => ["code" => "ar"], "components" => [["type" => "body", "parameters" => [["type" => "text", "text" => $file_name]]], ["type" => "button", "sub_type" => "url", "index" => "0", "parameters" => [["type" => "text", "text" => trim($file, 'https://crm.opts.expert/')]]]]]];


            }


            $response = $client->post(
                $url,
                ['form_params' => $data]
            );

            $d = json_decode($response->getBody(), true);

            try {
                if (count($d["messages"]) || str_contains($instanceId, 'FB')) {
                    $w = new WhatsappHistory();
                    $w->body = $urll;
                    $w->fromMe = 1;
                    $w->wid = str_contains($instanceId, 'FB') ? strtotime(date('Y-m-d H:i:s')) : $d["messages"][0]["id"];
                    $w->isForwarded = 0;
                    $w->time = strtotime(date('Y-m-d H:i:s'));
                    $w->chatId = $mobile;
                    $w->type = 'image';
                    $w->senderName = $instanceId;
                    $w->chatName = $mobile;
                    $w->instance_name = $instanceId;
                    $w->save();
                } else if ($d["sent"]) {
                    $message = $d["sent"] . " message: " . $d["message"] . " id : " . $d["id"] . " queueNumber: " . $d["queueNumber"] . " ";
                }
            } catch (\Exception $ex) {
                $message = "  wrong mobile: " . $mobile;

                return 0;
            }
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
            return 0;
        }
        return 1;
    }

    public function editButton($route, $className)
    {
        return '<a href="' . $route . '" class="btn btn-icon btn-active-light-primary w-30px h-30px ' . $className . '">
                <span class="svg-icon svg-icon-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
                <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
                <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
                </svg>
                </span>
                </a>';
    }

    public function deleteButton($route, $className, $attribute)
    {
        return '<a ' . $attribute . ' href=' . $route . ' class="btn btn-icon btn-active-light-primary w-30px h-30px ' . $className . '"
                    >
                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                    <span class="svg-icon svg-icon-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                fill="currentColor" />
                            <path opacity="0.5"
                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                fill="currentColor" />
                            <path opacity="0.5"
                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </a>';
    }

    public
    function getSelect(Request $request, $lang = 0)
    {

        $type = $request->type;
        $res[0] = ["id" => 0, "text" => ""];

        $module = $request->module;
        $category_id = $request->category_id;
        if ($type == "search_name") {
            if ($request->category == '251') {


                $sel = Captin::where(function ($q) use ($request, $lang) {
                    $q->where(DB::raw('name'), 'like', "%" . $request->term . "%");
                    $q->orwhere(DB::raw('mobile1'), 'like', "%" . $request->term . "%");
                })
                    ->pluck("name")->take(10)->toArray();
                return response()->json(
                    $sel

                );
            }
            if ($request->category == '249') {


                $sel = Restaurant::where(function ($q) use ($request, $lang) {
                    $q->where(DB::raw('name'), 'like', "%" . $request->term . "%");
                    $q->orwhere(DB::raw('telephone'), 'like', "%" . $request->term . "%");
                })
                    ->pluck("name")->take(10)->toArray();
                return response()->json(
                    $sel

                );
            }
            if ($request->category == '250') {
                $sel = \App\Models\Client::where(function ($q) use ($request, $lang) {
                    $q->where(DB::raw('name'), 'like', "%" . $request->term . "%");
                    $q->orwhere(DB::raw('mobile'), 'like', "%" . $request->term . "%");
                })
                    ->pluck("name")->take(10)->toArray();
                return response()->json(
                    $sel

                );
            }
        }
        if ($type == "getData") {
            if ($request->category == '251') {


                $data = Captin::where(function ($q) use ($request, $lang) {
                    $q->where(DB::raw('name'), $request->name);
                    $q->orwhere(DB::raw('mobile1'), $request->name);
                })
                    ->get()->first();


            }
            if ($request->category == '249') {


                $data = Restaurant::where(function ($q) use ($request, $lang) {
                    $q->where(DB::raw('name'), $request->name);
                    $q->orwhere(DB::raw('telephone'), $request->name);
                })
                    ->get()->first();
            }
            if ($request->category == '250') {
                $data = \App\Models\Client::where(function ($q) use ($request, $lang) {
                    $q->where(DB::raw('name'), $request->name);
                    $q->orwhere(DB::raw('mobile'), $request->name);
                })
                    ->get()->first();
            }


            if ($data)
                return response(['status' => true, 'message' => 'done', "data" => $data], 200);
            else
                return response(['status' => true, 'message' => 'done'], 200);
        }

        if ($type == 'purpose') {
            $category = $request->category;
            if (!$category)
                return response()->json(
                    ["results" => $res]

                );
            $count = 0;
            $sel = Constant::where('parent_id', $category);
            if ($request->term)
                $sel = $sel->where('name', 'like', '%' . $request->term . '%');
            $sel = $sel->get()->take(100);
            foreach ($sel as $c) {
                $res[$count] = ["id" => $c->id, "text" => $c->name];
                $count++;
            }
            return response()->json(
                ["results" => $res]

            );
        }
        if ($module == 'telephone') {
            $telephone = $request->telephone;
            $scrollWhatAppHis = view('tickets.whatsapp', [
                'call' => $telephone,
            ])->render();
            $result = Captin::withCount('callPhone', 'callPhone2', 'visits', 'smsPhone', 'tickets', 'orders')->where('mobile1', $telephone)->get()->first();
            if ($result)
                return response(['status' => true, 'message' => 'done', "category" => 192, "data" => $result, "scrollWhatAppHis" => $scrollWhatAppHis], 200);

            $result = Restaurant::with('callPhone', 'callPhone2', 'visits', 'smsPhone', 'tickets', 'orders')->where('telephone', $telephone)->get()->first();
            if ($result)
                return response(['status' => true, 'message' => 'done', "category" => 191, "data" => $result, "scrollWhatAppHis" => $scrollWhatAppHis], 200);
            else
                return response(['status' => true, 'message' => 'done', "category" => null, "data" => [], "scrollWhatAppHis" => ""], 200);

        }
        if ($module == 'employee') {
            $id = $request->id;
            $result = User::where('id', $id)->get()->first();

            if ($result)
                return response(['status' => true, 'message' => 'done', "category" => 192, "data" => $result], 200);
            else
                return response(['status' => true, 'message' => 'done', "category" => 192, "data" => []], 200);


        }

        if ($module == 'Item') {
            $desc = $request->category_id;
            $client_id = $request->client_id;
            $facility_id = $request->facility_id;
            $item = Item::where('description', $desc)->get()->first();
            $result = 0;
            if ($item) {
                if ($facility_id)
                    $result = ItemCost::where('item_id', $item->id)->where('facility_id', $facility_id)->orderBy('id','desc')->get()->first();


                else if ($client_id)
                    $result = ItemCost::where('item_id', $item->id)->where('client_id', $client_id)->orderBy('id','desc')->get()->first();
                else
                    $result=$item;

            }
            if($item && !$result)
                $result=$item;
            if ($result)
                return response(['status' => true, 'message' => 'done', "data" => $result], 200);
            else
                return response(['status' => true, 'message' => 'done', "data" => []], 200);


        }

        if ($type == 'employeeDepartment') {
            $department = $request->department;
            if (!$department)
                return response()->json(
                    ["results" => $res]

                );
            $count = 0;
            $sel = User::where('department_id', $department);
            if ($request->term)
                $sel = $sel->where('name', 'like', '%' . $request->term . '%');
            $sel = $sel->get()->take(100);
            foreach ($sel as $c) {
                $res[$count] = ["id" => $c->id, "text" => $c->name];
                $count++;
            }
            return response()->json(
                ["results" => $res]

            );
        }


        if ($type == 'vehicles') {
            $captin = $request->captin_id;
            if (!$captin)
                return response()->json(
                    ["results" => $res]

                );
            $count = 0;
            $sel = Vehicle::where('captin_id', $captin);
            if ($request->term)
                $sel = $sel->where('vehicle_no', 'like', '%' . $request->term . '%');
            $sel = $sel->get()->take(100);
            foreach ($sel as $c) {
                $res[$count] = ["id" => $c->id, "text" => $c->vehicle_no];
                $count++;
            }
            return response()->json(
                ["results" => $res]

            );
        }
        if ($type == 'projects') {
            $client = $request->client_id;
            if (!$client)
                return response()->json(
                    ["results" => $res]

                );
            $count = 0;
            $sel = ClientTrillionSocial::where('client_trillion_id', $client);
            if ($request->term)
                $sel = $sel->where('address', 'like', '%' . $request->term . '%');
            $sel = $sel->get()->take(100);
            foreach ($sel as $c) {
                $res[$count] = ["id" => $c->id, "text" => $c->address];
                $count++;
            }
            return response()->json(
                ["results" => $res]

            );
        }

        if ($module == 'Captin') {

            $data = Captin::find($category_id);
            if ($data)
                return response(['status' => true, 'message' => 'done', "data" => $data], 200);
        }
        $class = "App\\Models\\" . $module;
        $data = $class::find($category_id);

        if ($data)
            return response(['status' => true, 'message' => 'done', "data" => $data], 200);
        else
            return response(['status' => false, 'message' => 'error', "data" => ''], 401);


    }


    public function sendSMS(Request $request)
    {
        if (!$request->sms)
            $this->sendWhatsapp($this->refineMobile($request->mobile, 972), $request->input('content'), 0);

        if ($request->sms == 1)
            $this->sendSuperSMS('TabibFind', $request->mobile, $request->input('content'), $request->module, $request->module_id, $request->type);
    }

    public function sendSuperSMS($gateWay, $mobile, $msg, $module = 0, $module_id = 0, $type = 0)
    {
        smsapi()->gateway($gateWay)->sendMessage($mobile, $msg);
        $sms = new SystemSmsNotification();
        $sms->gateWay = 'Trillionz';
        $sms->message = $msg;
        $sms->mobile = $mobile;;
        $sms->channel = $gateWay;;
        $sms->module = $module;
        $sms->type_id = $module_id;
        $sms->sender_type = $type;
        $sms->sender_id = Auth::user()->id;
        $sms->sms_count = strlen($msg) / 52;
        $sms->module_id = $module_id;
        $sms->save();
    }

    public
    function LogNotification($module = 'crm', $id = 0, $type = 1, $EmailData = [], $user = 0, $subject = 0, $attachment = [], $sent_to = [], $sent_by = 'trillionz@developon.co', $sent_cc = [])
    {
        // try {
        $user ? $user : \Auth::user()->id;
        $sent_by == 0 ? $sent_by = 'trillionz@developon.co' : $sent_by = $sent_by;
        $path = public_path('uploads'); // upload directory
        Mail::send('parts.notification', $EmailData, function ($message) use ($path, $attachment, $subject, $sent_by, $sent_to, $sent_cc) {

            $message->from('trillionz@developon.co');

            if (is_array($sent_to)) {
                for ($i = 0; $i < count($sent_to); $i++)
                    if (filter_var($sent_to[$i], FILTER_VALIDATE_EMAIL))
                        $message->to($sent_to[$i]);
            }

            if (is_array($sent_cc)) {
                for ($i = 0; $i < count($sent_cc); $i++)
                    if (filter_var($sent_cc[$i], FILTER_VALIDATE_EMAIL))
                        $message->cc($sent_cc[$i]);
            }

            $message->subject($subject);

            if (is_array($attachment)) {
                for ($i = 0; $i < count($attachment); $i++)
                    $message->attach($attachment[$i]);
            }
        });
        if (is_array($sent_to)) {
            for ($i = 0; $i < count($sent_to); $i++)
                SystemMailNotification::create(['type' => $type, 'subject' => $subject, 'message' => $EmailData["content"], 'module' => $module, 'request_id' => $id, 'sent_to' => $sent_to[$i], 'sent_by' => 'system']);
        }

    }


}
