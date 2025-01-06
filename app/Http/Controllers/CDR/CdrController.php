<?php

namespace App\Http\Controllers\CDR;

use App\Http\Controllers\Controller;
use App\Models\Call;
use App\Models\Captin;
use App\Models\CdrLog;
use App\Models\Client;
use App\Models\ClientCallAction;
use App\Models\Restaurant;
use App\Models\RestaurantBranch;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CdrController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('CDR.index');
        }
        if ($request->isMethod('POST')) {
            $cdrLogs = CdrLog::query();
            return DataTables::eloquent($cdrLogs)
                ->filterColumn('from', function ($query, $keyword) use ($request) {
                    $value = $request->telephone;
                    $query->where(function ($q) use ($value) {
                        $q->where('from', 'like', "%" . $value . "%");
                        $q->orwhere('to', 'like', "%" . $value . "%");
                    });
                })
                ->editColumn('record_file_name', function ($cdrLog) {

                    if ($cdrLog->record_file_name)
                        return '<a href="https://wheels.developon.co/records/' . $cdrLog->record_file_name . '" target="_blank">Listen</a>';
                    else
                        return '';
                })
                ->editColumn('date', function ($cdrLog) {
                    return [
                        'display' => e(
                            $cdrLog->date->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $cdrLog->date->timestamp
                    ];
                })
                ->rawColumns(['record_file_name'])
                ->make();
        }
    }


    public function indexByPhone(Request $request)
    {

        if ($request->isMethod('POST')) {
            $telephone = $request->telephone;
            if (!$telephone)
                return [];
            $ids=$request->ids;

            $cdrLogs = CdrLog::query();
            $cdrLogs = $cdrLogs->where(function($q) use($telephone){$q->where('from', $telephone)->orwhere('to', $telephone);});
            if(isset($ids)&&count(explode(',',$ids))>1)
                $cdrLogs =$cdrLogs->wherein('id',explode(',',$ids));
            return DataTables::eloquent($cdrLogs)
                ->filterColumn('from', function ($query, $keyword) use ($request) {
                    $value = $request->telephone;
                    $query->where(function ($q) use ($value) {
                        $q->where('from', 'like', "%" . $value . "%");
                        $q->orwhere('to', 'like', "%" . $value . "%");
                    });
                })
                ->editColumn('record_file_name', function ($cdrLog) {

                    if ($cdrLog->record_file_name)
                        return '<a href="https://wheels.developon.co/records/' . $cdrLog->record_file_name . '" target="_blank">Listen</a>';
                    else
                        return '';
                })
                ->editColumn('date', function ($cdrLog) {
                    return [
                        'display' => e(
                            $cdrLog->date->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $cdrLog->date->timestamp
                    ];
                })
                ->rawColumns(['record_file_name'])
                ->make();
        }
    }


    public function indexMobile(Request $request, $mobile)
    {
        if(strlen($mobile)<7)
           return[];

        if ($request->isMethod('POST')) {
            $cdrLogs = CdrLog::query();
            if ($mobile)
                $cdrLogs->where(function ($q) use ($mobile) {
                    $q->where('from', 'like', "%" . $mobile . "%");
                    $q->orwhere('to', 'like', "%" . $mobile . "%");

                });
            $columns = $request->input('columns');
            $value = $columns[1]['search']['value'];
            if (strlen($value)>1)
                $cdrLogs->where(function ($q) use ($value) {
                    $q->where('from', 'like', "%" . $value . "%");
                    $q->orwhere('to', 'like', "%" . $value . "%");
                });

            return DataTables::eloquent($cdrLogs)
                ->editColumn('record_file_name', function ($cdrLog) {

                    if ($cdrLog->record_file_name)
                        return '<a href="https://wheels.developon.co/records/' . $cdrLog->record_file_name . '" target="_blank">Listen</a>';
                    else
                        return '';
                })
                ->editColumn('date', function ($cdrLog) {
                    return [
                        'display' => e(
                            $cdrLog->date->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $cdrLog->date->timestamp
                    ];
                })
                ->rawColumns(['record_file_name'])
                ->make();
        }
    }


    public function indexHistory(Request $request, $telephone)
    {

        if ($request->isMethod('GET')) {
            return view('CDR.index');
        }
        if ($request->isMethod('POST')) {
            $cdrLogs = CdrLog::query()->where(function ($q) use ($telephone) {
                $q->where('from', 'like', "%" . $telephone . "%");
                $q->orwhere('to', 'like', "%" . $telephone . "%");
            });;
            return DataTables::eloquent($cdrLogs)
                ->editColumn('date', function ($cdrLog) {
                    return [
                        'display' => e(
                            $cdrLog->date->format('m/d/Y h:i A')
                        ),
                        'timestamp' => $cdrLog->date->timestamp
                    ];
                })
                ->editColumn('record_file_name', function ($cdrLog) {

                    if ($cdrLog->record_file_name)
                        return '<a href="https://wheels.developon.co/records/' . $cdrLog->record_file_name . '" target="_blank">Listen</a>';
                    else
                        return '';
                })
                ->make();
        }
    }

    public function updateCalls(Request $request)
    {
        $client = new \GuzzleHttp\Client([
            'headers' => ['Content-Type' => 'application/json',

            ]
        ]);


        $token = $this->getToken();
        //try {
        $new = 0;
        $pbx = $client->get('//' . '176.65.31.30:8088' . '/openapi/v1.0/call/query?access_token=' . $token,
            ['form_params' => []]
        );
        $pbx = json_decode((string)$pbx->getBody(), true);
        $i = 0;
        $calls[] = [];
        // return $pbx;
        if (isset($pbx["data"])) {
            foreach ($pbx["data"] as $c) {
                $call_id = $c["call_id"];

                foreach ($c["members"] as $cc) {
                    $callin = [];
                    if (isset($cc["inbound"])) {
                        $ccc = $cc["inbound"];

                        if (($ccc["to"] == "0779998586" || $ccc["to"] == "225")) {
                            $client_name = '';
                            $callin = ClientCallAction::where('call_id', $call_id)->get()->first();
                            if (!$callin) {

                                // return json_encode(['call_id' => $call_id, 'call_action_id' => 1, 'active' => 1, 'telephone' => $ccc["from"], 'call_option_id' => 0, 'call_action' => 0, 'next_call' => date("Y-m-d H:i:s"), 'notes' => '', 'employee_id' => \Auth::user()->id]);
                                $restaurantB = RestaurantBranch::where(DB::raw('RIGHT(telephone,9)'), 'like', '%' . substr($ccc["from"], -9) . '%')->get()->first();
                                if ($restaurantB) {
                                    $restaurant = Restaurant::find($restaurantB->restaurant_id);
                                    $client_name = $restaurant->name;
                                }
                                $captin = Captin::where(DB::raw('RIGHT(mobile1,9)'), 'like', '%' . substr($ccc["from"], -9) . '%')
                                    ->orwhere(DB::raw('RIGHT(mobile2,9)'), 'like', '%' . substr($ccc["from"], -9) . '%')->get()->first();
                                if ($captin)
                                    $client_name = $captin->name;


                                $callin = ClientCallAction::create(['client_name' => $client_name, 'call_id' => $call_id, 'call_action_id' => 1, 'active' => 1, 'telephone' => $ccc["from"], 'call_option_id' => 37, 'call_action' => 0, 'next_call' => date("Y-m-d H:i:s"), 'notes' => '', 'employee_id' => \Auth::user()->id]);
                                $new = $ccc["member_status"];
                            } else {
                                $callin->update(['client_name' => $client_name, 'status' => 1, 'call_action_id' => 1, 'active' => 1, 'telephone' => $ccc["from"], 'call_option_id' => 37, 'call_action' => 0, 'next_call' => date('Y-m-d H:i:s'), 'notes' => '', 'employee_id' => \Auth::user()->id]);
                                $new = $ccc["member_status"];
                            }
                        }

                    }
                    $calls[$i] = ["pbx" => $pbx, "call" => $callin, "new" => $new];
                    $i++;
                }


            }
        }
        return $calls;
        /* } catch (\Exception $ex) {

             return $ex->getTrace();
         }*/

    }

    public function updateLocalCDR(Request $request)
    {
        $his = 0;
        $count = 0;
        foreach (CdrLog::updatemyData() as $p) {

            $call = CdrLog::where('uniqueid', $p->uniqueid)->get()->first();


        }
        return $count;

    }

    public function getToken()
    {
        $client = new \GuzzleHttp\Client([
            'headers' => ['Content-Type' => 'application/json',

            ]
        ]);
        if (\Auth::user()->refresh_token) {
            $refresh_token = \Auth::user()->refresh_token;

            $pbx = $client->post('//' . '176.65.31.30:8088' . '/openapi/v1.0/refresh_token',
                ['body' => '{"refresh_token": "' . $refresh_token . '"}']
            );
            $pbx = json_decode((string)$pbx->getBody(), true);
            if ($pbx["errcode"]) {

                $pbx = $client->post('//' . '176.65.31.30:8088' . '/openapi/v1.0/get_token',
                    ['body' => '{"username": "2Wr9d9ZHtiQjMTQEFi72Cs41eAXtPSkU","password": "y05KfPOtSbojGpLZhFOQA1ThWNwmqTeN"}']
                );
                $pbx = json_decode((string)$pbx->getBody(), true);
                if ($pbx["errcode"])
                    return 0;
                else {
                    $user = User::find(\Auth::user()->id);
                    if ($user) {
                        $user->refresh_token = $pbx["refresh_token"];
                        $user->save();
                    }
                    return $pbx["access_token"];
                }
            } else {
                $user = User::find(\Auth::user()->id);
                if ($user) {
                    $user->refresh_token = $pbx["refresh_token"];
                    $user->save();
                }
                return $pbx["access_token"];
            }
        } else {
            $client = new \GuzzleHttp\Client([
                'headers' => ['Content-Type' => 'application/json',


                ]
            ]);
            $pbx = $client->post('//' . '176.65.31.30:8088' . '/openapi/v1.0/get_token',
                ['body' => '{"username": "2Wr9d9ZHtiQjMTQEFi72Cs41eAXtPSkU","password": "y05KfPOtSbojGpLZhFOQA1ThWNwmqTeN"}']
            );
            $pbx = json_decode((string)$pbx->getBody(), true);
            if ($pbx["errcode"])
                return 0;
            else {
                $user = User::find(\Auth::user()->id);
                if ($user) {
                    $user->refresh_token = $pbx["refresh_token"];
                    $user->save();
                }
                return $pbx["access_token"];
            }

        }
        return 0;

    }

}
