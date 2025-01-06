<?php

namespace App\Http\Controllers;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Models\Attachment;
use App\Models\ClientTrillion;
use App\Models\Constant;
use App\Models\Contract;
use App\Models\ContractItem;
use App\Models\Hospital;
use App\Models\Item;
use App\Models\Objective;
use App\Models\Patient;
use App\Models\Vehicle;
use App\Models\WhatsappHistory;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesLog;

class DashboardController extends Controller
{

    public static $data = [];
    public function index(Request $request)
    {
        $type = $request->type;




        return view('dashboard.index');
    }
    public function employee(Request $request)
    {

        $data["from"] = $request->from;
        $data["to"] = $request->to;

        $data["employee_name"] = 'mahmoud';

        return view('dashboard.employees', $data);
    }

    public function getUnreadMessages(Request $request)
    {
        $token = -1;
        $instanace_id = -1;

        user()->SysUsr_ID;
        if ($request->sender == "Tabibfind") {
            $token = 'Tabibfind';
            $instanace_id = 'Tabibfind';
            $type = 'graph';
        }
        //self::updateWhatsAppMessages(10, $token, $instanace_id);
        $limit = $request->limit ? $request->limit : 10;
        $page = $request->page ? $request->page : 0;
        if ($request->type == "count") {
            $messages = WhatsappHistory::getWhataaAppList([], 1, 0, 0, 0, $token, 0, 2);
            return $messages->count();
        }
        self::$data['sender'] = $request->sender;
        self::$data['token'] = $token;
        self::$data['lang'] = \Auth::user("admin")->lang;
        $lastChat = WhatsappHistory::where('instance_name', $token)->orderBy('time', 'desc')->get()->first();

        if ($lastChat)
            $now = Carbon::parse(date('Y-m-d H:i:s', $lastChat->time));
        else
            $now = Carbon::now();


        $messages = WhatsappHistory::select('chatId', \Illuminate\Support\Facades\DB::raw('max(time) as time'))->where('instance_name', $token);
        $search = $request->input('inputsearch');

        if (isset($search) && $search) {
            $messages = $messages->where(function ($q) use ($search) {
                $q->where('whatsapp_histories.body', 'like', "%" . $search . "%");
                $q->orwhere('whatsapp_histories.senderName', 'like', "%" . $search . "%");
                $q->orwhere('whatsapp_histories.chatName', 'like', "%" . $search . "%");
                $q->orwhere('whatsapp_histories.chatId', 'like', "%" . $search . "%");
            });
        }

        self::$data['senders'] = $messages->orderby(DB::raw('max(time)'), 'desc')->groupBy('chatId')->paginate($limit, $columns = ['*'], 'page', $page);
        $filter = [];
        $filter['key'] = $search;
        self::$data['inputsearch'] = $filter;
        self::$data['role'] = \Auth::user()->role;
        self::$data['user_id'] = \Auth::user()->SysUsr_ID;
        self::$data['page'] = 2;
        if ($page > 0) {

            return view('dashboard.unreadWhatsAppMore', self::$data);
        }
        return view('dashboard.unreadWhatsApp', self::$data);
        /*        else
                    return redirect(self::$data['cp_route_name']);*/
    }

    public function getWhatsAppMessage(Request $request)
    {
        $token = -1;
        $instanace_id = -1;
        if ($request->sender == "Tabibfind") {
            $token = 'Tabibfind';
            $instanace_id = 'Tabibfind';
            $type = 'graph';
        } else
            return "";
        self::$data["patient"] = $request->patient;
        self::$data["sender"] = $request->sender;
        self::$data["mobile"] = $request->mobile;
        self::$data['lang'] = \Auth::user("admin")->lang;
        self::$data["role"] = \Auth::user("admin")->role;
        self::$data['user_id'] = \Auth::user()->SysUsr_ID;
        $search = $request->input('inputsearch');
        $filter = [];
        $filter['key'] = $search;
        self::$data['inputsearch'] = $filter;
        if (!$request->mobile || strlen($request->mobile) < 6)
            return "Error in Mobile No";
        $limit = 50;
        //self::updateWhatsAppMessages(20, $token, $instanace_id);
        $messages = WhatsappHistory::getWhataaAppList($filter, 0, 0, 0, $request->mobile, $token)->orderby('time', 'desc');
        if ($request->limit)
            $messages = $messages->whereNull('ack');
        $messages = $messages->take($limit)->get();
        self::$data["messages"] = $messages;

        foreach ($messages as $m)
            $m->update(['ack' => 'viewed']);

        self::$data["message"] = $request->message;
        if ($request->limit || $request->search == 1)
            return view('dashboard.newchat', self::$data);

        return view('dashboard.chat', self::$data);
    }

    public function sendWhatsappChat(Request $request)
    {
        try {
            $token = -1;
            $instanace_id = -1;
            $type = 0;
            if ($request->sender == "Tabibfind") {
                $token = 'Tabibfind';
                $instanace_id = 'Tabibfind';
                $type = 'graph';
            }
            if ($token == -1 && $request->ajax())
                return response(['status' => false, 'message' => "error no sender"], 401);
            if ($token == -1 && !$request->ajax())
                redirect()->to("" . self::$data['web_url'])->send();

            if (str_contains($instanace_id, 'FB')) {

                self::sendWhatsapp($request->mobile, $request->message, $type, $token, $instanace_id);
            } else {
                $mobile = self::refineMobile($request->mobile, 0);
                //return $mobile." ". $request->message." ". $type." ". $token." ". $instanace_id;
                self::sendWhatsapp($mobile, $request->message, $type, $token, $instanace_id);
            }
            // self::sendWhatsapp($mobile, $request->message, $type, $token, $instanace_id);
            return response(array('status' => 2, 'message' => 'Done'));
        } catch (Exception $ex) {
            return response(array('status' => 0, 'message' => $ex->getMessage()));
        }
    }

    public function createAtt(Request $request)
    {
        $sender = $request->sender;
        $mobile = $request->mobile;

        $attachmentConstants = Constant::where('module', Modules::CAPTIN)
            ->where('field', DropDownFields::ATTACHMENT_TYPE)->get();
        $createView = view('dashboard.attachments.addedit_modal', [
            'sender' => $sender,
            'mobile' => $mobile,
            'attachmentConstants' => $attachmentConstants,
            'selectedConstant' => []
        ])->render();

        return response()->json(['createView' => $createView]);
    }


    public function storeAtt(Request $request)
    {
        $request->attachment_file->store('captins/attachments');

        $attachment = new Attachment([
            'attachable_id' => $request->mobile,
            'attachment_type_id' => $request->attachment_type_id,
            'file_hash' => $request->attachment_file->hashName(),
            'file_name' => $request->attachment_file->getClientOriginalName(),
        ]);

        if ($attachment) {
            $link = "https://wheels.developon.co/attachments/" . $attachment->file_hash;
            $instanace_id = -1;
            $token = -1;

            if ($request->sender == "Tabibfind") {
                $token = 'Tabibfind';
                $instanace_id = 'Tabibfind';
                $type = 'graph';
            }
            if ($token == -1)
                return redirect('/');


            $this->sendWhatsappFile($request->mobile, $link, $attachment->file_name, $type, $token, $instanace_id);

            return response()->json(['status' => true, 'message' => 'Attachment has been added successfully!']);
        } else {
            return response()->json(['status' => true, 'message' => 'Attachment has been added successfully!']);
        }
    }

    public function getSelect2Details(Request $request)
    {
        try {
            // Determine the model dynamically
            $modelClass = $request->get('model');
            if (!class_exists($modelClass) || !isset($request->model_id)) {
                throw new Exception(t("Item Not Found"));
            }
            $item = $modelClass::query();
            $item = $item->find($request->model_id);
            // $item = null;
            if (!$item) {
                throw new Exception(t("Item Not Found"));
            }
            return response(['status' => true, 'message' => 'done', "item" => $item ?: []], 200);
        } catch (Exception $ex) {
            return response()->json(['status' => false, 'message' => $ex->getMessage()], 401);
        }
    }
    public function getSelect2(Request $request)
    {
        $search = $request->get('q');
        $page = $request->get('page', 1);
        $perPage = 10;
        // Log initial request data
        Log::info('Select2 request received', ['search' => $search, 'page' => $page, 'model' => $request->get('model')]);

        // Determine the model dynamically
        $modelClass = $request->get('model');
        $parent_ids = $request->get('parent_id');

        // Log model determination
        if (!class_exists($modelClass)) {
            Log::warning('Model class does not exist', ['modelClass' => $modelClass]);
            return response()->json(['items' => [], 'total_count' => 0]);
        }
        if (!empty($parent_ids)) {
            Log::info("Filtering by parent id.", ['value' => $parent_ids]);
            $parent_ids = filterArrayForNullValues($parent_ids);
            Log::info('Filtered values:', ['parent_ids' => $parent_ids]);
            if (count($parent_ids) > 0) {
            } else {
                Log::info("No valid values to filter for parent_id.");
            }
        }



        $query = $modelClass::query();
        if ($search) {
            Log::info('Search parameter provided', ['search' => $search]);
            if ($modelClass == ClientTrillion::class) {
                Log::info('Building query for Client model');
                $locales = config('app.locales'); // Fetch locales from the config file
                Log::info('Fetched locales for search', ['locales' => $locales]);
                $query->where(function ($q) use ($locales, $search) {
                    $q->where('name', 'like', "%$search%");
                    $q->orWhere('name_en', 'like', "%$search%");
                    $q->orWhere('name_h', 'like', "%$search%");
                    // Additional conditions for mobile, id_number, and passport_number
                    $q->orWhere('mobile', 'like', '%' . $search . '%')->orWhere('telephone', 'like', '%' . $search . '%');
                });
            } else {
                Log::warning('Unsupported model class for search', ['modelClass' => $modelClass]);
                return response()->json(['items' => [], 'total_count' => 0]);
            }
        }

        // Log the query just before execution
        Log::info('Final query before execution', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);

        // Execute the query and paginate
        $items = $query->latest('updated_at')->paginate($perPage, ['*'], 'page', $page);
        Log::info('Query executed and paginated', ['total_items' => $items->total()]);

        $results = [
            'items' => $items->map(function ($item) use ($modelClass) {
                $name = 'NA';
                if ($modelClass == Vehicle::class) {
                    $vehicle_type = isset($item->vehicle_type) ? $item->vehicle_type->name : "NA";
                    $brand = isset($item->brand) ? $item->brand->name : 'NA';
                    $name = $vehicle_type . ' - ' . $brand . ' - ' . $item->plate_number;
                } else {
                    $name = $item->name ?? "NA";
                }
                return [
                    'id' => $item->id,
                    'name' => $name,
                ];
            }),
            'total_count' => $items->total()
        ];

        Log::info('Select2 response prepared', ['results' => $results]);

        return response()->json($results);
    }
    public function getSelect2WithoutSearchOrPaginate(Request $request)
    {
        Log::info('Starting getSelect2WithoutSearchOrPaginate function');

        try {
            // Step 1: Determine the model class and parent_id from the request
            $modelClass = $request->get('model');
            $parent_id = $request->get('parent_id');
            Log::info('Step 1: Determined model class and parent_id', ['modelClass' => $modelClass, 'parent_id' => $parent_id]);

            // Step 2: Validate if the model class exists
            if (!class_exists($modelClass)) {
                Log::warning('Step 2: Model class does not exist', ['modelClass' => $modelClass]);
                throw new \Exception("Model class '{$modelClass}' does not exist");
            }
            Log::info('Step 2: Model class validation passed');

            // Step 3: Initialize the query
            $query = $modelClass::query();
            Log::info('Step 3: Query initialized for model', ['modelClass' => $modelClass]);

            // Step 4: Apply conditional logic based on model class and parent_id
            if ($parent_id) {
                Log::info('Step 4: Parent ID provided, applying conditions', ['parent_id' => $parent_id]);
                $query->when($parent_id, function ($qq) use ($parent_id, $modelClass) {
                    if ($modelClass == Constant::class) {
                        Log::info('Applying condition for Constant model', ['parent_id' => $parent_id]);
                        is_array($parent_id) ? $qq->whereIn('parent_id', $parent_id) : $qq->where('parent_id', $parent_id);
                    } elseif ($modelClass == ContractItem::class) {
                        Log::info('Applying condition for ContractItem model', ['parent_id' => $parent_id]);
                        $qq->select('contract_items.*', 'items.description as name', 'contracts.duration as contract_duration')
                            ->join('contracts', 'contract_items.contract_id', '=', 'contracts.id')
                            ->join('items', 'contract_items.item_id', '=', 'items.id')
                            ->where('contract_items.contract_id', $parent_id)
                            ->whereNull('contract_items.deleted_at')
                            ->whereNull('items.deleted_at');
                    } else {
                        Log::error('Unsupported model class for parent_id filtering', ['modelClass' => $modelClass]);
                        throw new \Exception("Unsupported model class '{$modelClass}' for parent_id filtering");
                    }
                });
            } else {
                Log::info('Step 4: No parent ID provided, no additional query conditions applied');
            }

            // Step 5: Log the full SQL query with bindings
            $sql = $query->toSql();
            $bindings = $query->getBindings();
            Log::info('Step 5: Prepared SQL query', ['sql' => $sql, 'bindings' => $bindings]);

            // Step 6: Execute the query
            $items = $query->get();
            Log::info('Step 6: Query executed', ['items_count' => $items->count()]);

            // Step 7: Map the results to include the name in the current locale
            $mappedItems = $items->map(function ($item) {
                $item->current_local_name = $item->name ?? $item->description;
                return $item;
            });
            Log::info('Step 7: Items mapped with current local name', ['mapped_items_count' => $mappedItems->count()]);

            // Step 8: Return the response
            Log::info('Step 8: Returning JSON response');
            return response()->json($mappedItems);
        } catch (\Exception $e) {
            Log::error('Error in getSelect2WithoutSearchOrPaginate', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
            // return response()->json(['items' => []]);
        }
    }

    // In DashboardController

    public function storeObjective(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'objective_type_id' => 'required|exists:constants,id'
            ]);
            // dd('storeObjective', $request->all());
            $objective = Objective::firstOrCreate(
                [
                    'name' => $request->name,
                    'objective_type_id' => $request->objective_type_id
                ],
                ['is_active' => true]
            );

            return response()->json([
                'status' => true,
                'data' => $objective
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error creating objective'
            ], 500);
        }
    }
    public function getObjectives(Request $request)
    {
        try {
            $perPage = 10;
            $page = $request->page ?: 1;

            $query = Objective::where('is_active', true);

            // Filter by objective type
            if ($request->objective_type_id) {
                $query->where('objective_type_id', $request->objective_type_id);
            }

            // If model class and ID are provided, get related objectives
            if ($request->model_class && $request->model_id) {
                $modelClass = $request->model_class;
                $modelId = $request->model_id;

                // Get the model instance
                $model = $modelClass::find($modelId);

                if ($model) {
                    // Get IDs of related objectives
                    $relatedObjectiveIds = $model->objectives()
                        ->where('objective_type_id', $request->objective_type_id)
                        ->pluck('objectives.id');

                    // Add these to the query
                    $query->whereIn('id', $relatedObjectiveIds);
                }
            }

            // Search filter
            if ($request->q) {
                $query->where('name', 'like', '%' . $request->q . '%');
            }

            $total = $query->count();

            $objectives = $query
                ->select('id', 'name')
                ->orderBy('name', 'asc')
                ->skip(($page - 1) * $perPage)
                ->take($perPage)
                ->get();

            return response()->json([
                'status' => true,
                'data' => $objectives,
                'pagination' => [
                    'more' => $total > ($page * $perPage)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'data' => [],
                'pagination' => ['more' => false],
                'message' => 'Error fetching objectives'
            ], 500);
        }
    }
    /**
     * Remove an attachment
     *
     * @param Project $project
     * @param Attachment $attachment
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove_attachment(Attachment $attachment)
    {
        Log::info('Starting to remove task attachment', [
            'attachment_id' => $attachment->id,
            'user_id' => auth()->id()
        ]);

        try {
            DB::beginTransaction();
            $filePath = $attachment->file_path;
            // Delete the attachment
            $attachment->delete();
            // Remove the physical file
            if (file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
            DB::commit();
            Log::info('Attachment removed successfully', [
                'attachment_id' => $attachment->id,
                'file_path' => $filePath,
                // 'project_id' => $project->id
            ]);

            return response()->json([
                'success' => true,
                'message' => __('File removed successfully')
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error removing task attachment', [
                'attachment_id' => $attachment->id,
                // 'project_id' => $project->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => __('Failed to remove file: ') . $e->getMessage()
            ], 500);
        }
    }
}
