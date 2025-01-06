<?php

namespace App\Http\Controllers\Calls;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Http\Controllers\Controller;
use App\Models\Call;
use App\Models\CallQuestionnaire;
use App\Models\CallQuestionnaireResponse;
use App\Models\Constant;
use App\Models\MarketingCallAction;
use App\Models\Captin;
use App\Models\ShortMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CaptinCallController extends Controller
{

    public function view_captins_calls(Request $request, Captin $captin)
    {
        $captinCalls = Call::where('captin_id', $captin->id)->with(
            'callAction',
            'captinAction',
            'user',
        )
            ->withCount('callQuestionnaireResponses')
            ->orderBy('created_at', 'desc')->get();





        $outgoingCalls = view('calls.captin_outgoing_calls_card', [
            'calls' => $captinCalls->where('call_type', 'outgoing_call'),
            'captin' => $captin,
        ])->render();
        $captinSms = ShortMessage::where('captin_id', $captin->id)->with('type')
            ->orderBy('created_at', 'desc')->get();

        $incomingCalls = view('calls.captin_incoming_calls_card', [
            "SmsMessages"=>$captinSms,
            'captin' => $captin,
        ])->render();




        $result =  $outgoingCalls . '<div class="separator separator-dashed my-4"></div>' . $incomingCalls . '<div class="separator separator-dashed my-4"></div>' ;


        return response()->json(['drawerView' => $result, 'captinName' => 'Captin Calls - ' . $captin->name]);
    }

    public function view_call_questionnaire_responses(Request $request, Call $call)
    {
        $call->load('callQuestionnaireResponses');
        // $call->load('callQuestionnaireResponses.questionnaire');
        // $call->load('callQuestionnaireResponses.question');
        $questionnaire = $call->callQuestionnaireResponses->pluck('questionnaire')->first();

        $call = $call->callQuestionnaireResponses->pluck('call')->first();
        $captin = $call->captin();
        // dd($questionnaire->title);
        // foreach ($call->callQuestionnaireResponses as $key => $value) {
        //     dd($value);
        // }
        $viewResult = view('calls.questionnaire_responses_table', [
            'responses' => $call->callQuestionnaireResponses,
            'questionnaire' => $questionnaire,
            'call' => $call
        ])->render();

        return response()->json(['drawerView' => $viewResult, 'captinName' => 'Captin Calls - ' ]);
    }

    public function create(Request $request, Captin $captin)
    {

        $callActions = Constant::where('field',  DropDownFields::CAPTIN_CALL_ACTION)->where('module', Modules::CAPTIN)->get();
        $callCaptinActions = Constant::where('field',  DropDownFields::CAPTIN_ACTION)->where('module', Modules::CAPTIN)->get();

        $questionnaires = CallQuestionnaire::all();

        $EMPLOYEES = [];

        if (Auth::user()->hasRole('super-admin')) {
            $EMPLOYEES = User::all();
        } else {
            $EMPLOYEES = User::where('id', Auth::user()->id)->get();
        }

        $createView = view('calls.addedit_modal', [
            'captin' => $captin,
            'CALL_ACTION' => $callActions,
            'CALL_CAPTIN_ACTIONS' => $callCaptinActions,
            'EMPLOYEES' => $EMPLOYEES,
            'questionnaires' => $questionnaires
        ])->render();
        return response()->json(['createView' => $createView]);
    }


    private function EnsureUserId($user_id)
    {
        if (Auth::user()->hasRole('super-admin')) {
            return $user_id;
        } else {
            return Auth::user()->id;
        }
    }

    public function store(Request $request, Captin $captin)
    {
        $request->validate([
            'call_action_id' => 'required',
            'captin_action_id' => 'required',
            'user_id' => Rule::requiredIf(Auth::user()->hasRole('super-admin')),
            'next_call' => 'required',
            'notes' => 'required',
        ]);
        $newCall = new Call();

        $newCall->captin_id = $captin->id;
        $newCall->call_action_id = $request->call_action_id;
        $newCall->captin_action_id = $request->captin_action_id;
        $newCall->user_id = $this->EnsureUserId($request->user_id);
        $newCall->next_call = $request->next_call;
        $newCall->notes = $request->notes;
        $newCall->call_type = 'outgoing_call';

        $newCall->save();

        if ($request->has('call_questionnaire')) {
            foreach ($request->call_questionnaire as $call_questionnaire_key => $questionIds) {
                foreach ($questionIds['questionId'] as $quetionId => $questionResponse) {
                    CallQuestionnaireResponse::create([
                        'call_id' => $newCall->id,
                        'module' => 'captin',
                        'call_questionnaire_id' => $call_questionnaire_key,
                        'cq_question_id' => $quetionId,
                        'answer' => $questionResponse
                    ]);
                }
            }
        }

        return response()->json(['status' => true, 'message' => 'Call has been added successfully!']);
    }


    public function edit(Request $request, Captin $captin, Call $Call)
    {
        $createView = view('calls.addedit_modal', ['call' => $Call])->render();
        return response()->json(['createView' => $createView]);
    }

    public function update(Request $request, Captin $captin, Call $Call)
    {
        $request->validate([
            'call_action_id' => 'required',
            'captin_action_id' => 'required',
            'user_id' => Rule::requiredIf(Auth::user()->hasRole('super-admin')),
            'next_call' => 'required',
            'notes' => 'required',
        ]);

        $Call->captin_id =  $captin->id;
        $Call->call_action_id = $request->call_action_id;
        $Call->captin_action_id = $request->captin_action_id;
        $Call->user_id = $this->EnsureUserId($request->user_id);
        $Call->next_call =  $request->next_call;
        $Call->notes =  $request->notes;

        $Call->save();
        return response()->json(['status' => true, 'message' => 'Call Updated']);
    }

    public function delete(Request $request, Call $Call)
    {
        $Call->delete();
        return response()->json(['status' => true, 'message' => 'Call Deleted Successfully !']);
    }
}
