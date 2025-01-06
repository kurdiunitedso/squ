<?php

namespace App\Http\Controllers\Calls;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Http\Controllers\Controller;
use App\Models\Call;
use App\Models\CallCallTask;
use App\Models\CallQuestionnaire;
use App\Models\CallQuestionnaireResponse;
use App\Models\Constant;
use App\Models\MarketingCallAction;
use App\Models\CallTask;
use App\Models\ShortMessage;
use App\Models\ShortMessageCallTask;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CallTasksCallController extends Controller
{

    public function view_callTasks_calls(Request $request, CallTask $callTask)
    {
        $callTaskCalls = CallCallTask::where('callTask_id', $callTask->id)->with(
            'callAction',
            'callTaskAction',
            'user'
        )            ->withCount('callQuestionnaireResponses');





        $outgoingCalls = view('calls_call_tasks.calls_call_tasks_outgoing_calls_card', [
            'calls' => $callTaskCalls->where('call_type', 'outgoing_call')->get(),
            'callTask' => $callTask,
        ])->render();
        $callTaskSms = ShortMessageCallTask::where('callTask_id', $callTask->id)->with('type')
            ->orderBy('created_at', 'desc')->get();

        $incomingCalls = view('calls_call_tasks.calls_call_tasks_incoming_calls_card', [
            "SmsMessages"=>$callTaskSms,
            'callTask' => $callTask,
        ])->render();




        $result =  $outgoingCalls . '<div class="separator separator-dashed my-4"></div>' . $incomingCalls . '<div class="separator separator-dashed my-4"></div>' ;


        return response()->json(['drawerView' => $result, 'callTaskName' => 'CallTask Calls - ' . $callTask->name]);
    }

    public function view_call_questionnaire_responses(Request $request, CallCallTask $callTask)
    {
        $call=$callTask;
        $call->load('callQuestionnaireResponses');
        // $call->load('callQuestionnaireResponses.questionnaire');
        // $call->load('callQuestionnaireResponses.question');
        $questionnaire = $call->callQuestionnaireResponses->pluck('questionnaire')->first();
 //return $call;
        $call2 = $call->callQuestionnaireResponses->pluck('call')->first();
        $callTask = $call->callTask();
        // dd($questionnaire->title);
        // foreach ($call->callQuestionnaireResponses as $key => $value) {
        //     dd($value);
        // }
        $viewResult = view('calls_call_tasks.questionnaire_responses_table', [
            'responses' => $call->callQuestionnaireResponses,
            'questionnaire' => $questionnaire,
            'call' => $call
        ])->render();

        return response()->json(['drawerView' => $viewResult, 'callTaskName' => 'CallTask Calls - ' ]);
    }

    public function create(Request $request, CallTask $callTask)
    {

        $callActions = Constant::where('field',  DropDownFields::CALL_ACTION)->where('module', Modules::CALL)->get();


        $questionnaires = CallQuestionnaire::all();

        $EMPLOYEES = [];

        if (Auth::user()->hasRole('super-admin')) {
            $EMPLOYEES = User::all();
        } else {
            $EMPLOYEES = User::where('id', Auth::user()->id)->get();
        }

        $createView = view('calls_call_tasks.addedit_modal', [
            'callTask' => $callTask,
            'CALL_ACTION' => $callActions,
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

    public function store(Request $request, CallTask $callTask)
    {
        $request->validate([
            'call_action_id' => 'required',
            'user_id' => Rule::requiredIf(Auth::user()->hasRole('super-admin')),
            'next_call' => 'required',
            'notes' => 'required',
        ]);
        $newCall = new CallCallTask();

        $newCall->callTask_id = $callTask->id;
        $newCall->call_action_id = $request->call_action_id;
        $newCall->callTask_action_id = $request->callTask_action_id;
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
                        'module' => 'callTask',
                        'call_questionnaire_id' => $call_questionnaire_key,
                        'cq_question_id' => $quetionId,
                        'answer' => $questionResponse
                    ]);
                }
            }
        }

        return response()->json(['status' => true, 'message' => 'Call has been added successfully!']);
    }


    public function edit(Request $request, CallTask $callTask, Call $Call)
    {
        $createView = view('calls_call_tasks.addedit_modal', ['call' => $Call])->render();
        return response()->json(['createView' => $createView]);
    }

    public function update(Request $request, CallTask $callTask, CallCallTask $Call)
    {
        $request->validate([
            'call_action_id' => 'required',

            'user_id' => Rule::requiredIf(Auth::user()->hasRole('super-admin')),
            'next_call' => 'required',
            'notes' => 'required',
        ]);

        $Call->callTask_id =  $callTask->id;
        $Call->call_action_id = $request->call_action_id;
        $Call->callTask_action_id = 1;
        $Call->user_id = $this->EnsureUserId($request->user_id);
        $Call->next_call =  $request->next_call;
        $Call->notes =  $request->notes;

        $Call->save();
        return response()->json(['status' => true, 'message' => 'Call Updated']);
    }

    public function delete(Request $request, CallCallTask $callTask)
    {
        $callTask->delete();

        return response()->json(['status' => true, 'message' => 'Call Deleted Successfully !']);
    }
}
