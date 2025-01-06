<?php

namespace App\Http\Controllers\Offers;

use App\Enums\DropDownFields;
use App\Enums\Modules;
use App\Exports\OffersExport;
use App\helper\CustomPDFApp;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\CdrLog;
use App\Models\City;
use App\Models\ClientTrillion;
use App\Models\FacilityCallAction;
use App\Models\Facility;
use App\Models\Constant;
use App\Models\Contract;
use App\Models\ContractItem;
use App\Models\Country;
use App\Models\Lead;
use App\Models\Offer;

use App\Models\SystemSmsNotification;
use App\Services\Dashboard\Filters\OfferFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;
use Psy\Util\Str;
use Yajra\DataTables\Facades\DataTables;

class OfferController extends Controller
{
    protected $filterService;
    private $_model;

    public function __construct(Offer $_model, OfferFilterService $filterService)
    {
        $this->_model = $_model;
        $this->filterService = $filterService;
        Log::info('............... ' . $this->_model::ui['controller_name'] . ' initialized with ' . $this->_model::ui['s_ucf'] . ' model ...........');
    }
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            return $this->showIndexPage();
        }

        if ($request->isMethod('POST')) {
            return $this->handleDataTableRequest($request);
        }
    }

    private function showIndexPage()
    {
        $status = Constant::where('module', Modules::offer_module)
            ->where('field', DropDownFields::status)
            ->get();

        $types = Constant::where('module', Modules::offer_module)
            ->where('field', DropDownFields::OFFER_TYPE)
            ->get();

        $facilities = Facility::all();

        return view($this->_model::ui['route'] . '.index', [
            '_model' => $this->_model,
            'facilities' => $facilities,
            'status' => $status,
            'types' => $types,
        ]);
    }

    private function handleDataTableRequest(Request $request)
    {
        $query = $this->_model->query()->with(['visit', 'facility', 'status', 'type', 'contract'])
            ->withCount(['items', 'attachments']);

        if ($request->has('params')) {
            $query = $this->filterService->apply($query, $request->input('params'));
        }
        $query->latest('offers.updated_at');

        return DataTables::eloquent($query)
            ->editColumn('facility.name', function ($item) {
                return (!isset($item->facility)) ? '' : '<a href="' . route($this->_model::ui['route'] . '.edit', [$this->_model::ui['s_lcf'] => $item->id]) . '" targer="_blank" class="">
                 ' . $item->facility->name . '
            </a>';
            })
            ->editColumn('title', function ($offer) {
                return '<a href="' . route('offers.edit', ['offer' => $offer->id]) . '" targer="_blank" class="">
                         ' . $offer->title . '
                    </a>';
            })
            ->editColumn('facility.telephone', function ($offer) {
                if ($offer->facility) {
                    return '<a href="' . route('offers.view_calls', ['offer' => $offer->id]) . '"  class="viewCalls" data-kt-calls-table-actions="show_calls">'
                        . $offer->facility->telephone .
                        '</a>';
                }
            })
            ->editColumn('visit.id', function ($offer) {
                if ($offer->visit) {
                    return '<a href="' . route('visits.edit', ['visit' => $offer->visit->id]) . '?updateAnswer=1" size="modal-xl" class="btnUpdatevisit" >'
                        . $offer->visit->id . ' </a>';
                }
                return 'NA';
            })
            ->editColumn('contract.id', function ($offer) {
                if ($offer->contract) {
                    return '<a href="' . route(Contract::ui['route'] . '.edit', [Contract::ui['s_lcf'] => $offer->contract->id]) . '?updateAnswer=1" size="modal-xl" class="" >'
                        . $offer->contract->id . ' </a>';
                }
                return 'NA';
            })
            ->editColumn('status', function ($item) {
                if (!$item->status) {
                    return '<span class="badge badge-light">NA</span>';
                }
                $backgroundColor = $item->status->color;
                $textColor = getContrastColor($backgroundColor);

                $btnClass = 'btnChangeStatus' . $item::ui['s_ucf'];

                return sprintf(
                    '<a href="%s"
                                class="status-badge badge fw-bold %s"
                                style="background-color: %s; color: %s"
                                data-policy-offer-id="%s"
                                data-status-id="%s"
                                data-modal-size="modal-sm">
                                %s
                            </a>',
                    '#',
                    // route($item::ui['route'] . '.get_status_form', ['_model' => $item->id]),
                    $btnClass,
                    $backgroundColor,
                    $textColor,
                    $item->id,
                    $item->status->id,
                    $item->status->name
                );
            })

            ->editColumn('items_count', function ($offer) {
                return '<a href="' . route('offers.view_items', ['offer' => $offer->id]) . '?type=items" title="items" data_id="' . $offer->id . '"  class="menu-link px-3 viewItem" >
                     ' . $offer->items_count . '
                    </a>';
            })
            ->editColumn('attachments_count', function ($offer) {
                return '<a href="' . route('offers.view_attachments', ['offer' => $offer->id]) . '?type=attachments" title="attachments"  class="menu-link px-3 viewCalls" >
                     ' . $offer->attachments_count . '
                    </a>';
            })
            ->editColumn('active', function ($offer) {
                return $offer->active
                    ? '<h4 class="text text-success bold">Yes</h4>'
                    : '<h4 class="text text-danger bold">No</h4>';
            })
            ->addColumn('action', function ($item) {
                return $item->action_buttons;
            })
            ->escapeColumns([])
            ->make();
    }


    public function create(Request $request)
    {
        $countries = Country::all();
        $status = Constant::where('module', Modules::offer_module)->where('field', DropDownFields::offer_status)->get();
        $facilities = Facility::all();
        $company_types = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::facility_type)->get();
        $Types = Constant::where('module', Modules::offer_module)->where('field', DropDownFields::OFFER_TYPE)
            ->get();
        $pos_type = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::POS_TYPE)->get();
        $OSTYPES = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::OS_TYPE)->get();
        $type_id = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_TYPE)->get();
        $BANKS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();
        $PAYMENTTYPES = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::PAYMENT_TYPE)->get();
        $preparation_time = DropDownFields::PREPARATION_TIME;
        $printer_type = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::printer_type)->get();
        $sys_satisfaction_rate = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::sys_satisfaction_rat)->get();
        $cities = City::all();
        $category_id = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_CATEGORY)->get();
        $titles = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::titles)->get();
        $lead = Lead::find($request->lead_id);
        $facility = 0;
        if ($request->facility_id == null) {
            $facility = Facility::where('telephone', $request->mobile)->get()->first();
        }
        if (isset($request->facility_id)) {
            $facility = Facility::findOrFail($request->facility_id);
        }
        if (!$facility && $lead)
            $facility = $lead->facility;

        $createView = view('offers.addedit', [
            'facilities' => $facilities,
            'status' => $status,

            'typesOffer' => $Types,
            'countries' => $countries,
            'projects' => [],
            'company_types' => $company_types,
            'cities' => $cities,
            'TYPES' => $Types,
            'OSTYPES' => $OSTYPES,
            'preparation_time' => $preparation_time,
            'BANKS' => $BANKS,
            'CATEGORYS' => $category_id,
            'printer_type' => $printer_type,
            'sys_satisfaction_rate' => $sys_satisfaction_rate,
            'titles' => $titles,
            'PAYMENT_TYPES' => $PAYMENTTYPES,
            'facilityTypes' => $type_id,
            'facility' => $facility,
            'lead' => $lead,
            'posTypes' => $pos_type
        ])->render();
        return $createView;
    }

    public function add_contract(Request $request, Offer $offer)
    {
        try {
            DB::beginTransaction();
            Log::info('Starting add_contract process for Offer ID: ' . $offer->id);

            $facility = $offer->facility;
            Log::info('Facility data retrieved:', ['facility_id' => $facility->id]);

            // Map facility data to client_trillions format
            $clientData = [
                'mobile' => $facility->whatsapp,
                'telephone' => $facility->telephone,
                'name' => $facility->name,
                'name_en' => $facility->name_en,
                'registration_number' => $facility->facility_id,
                'company_type' => $facility->type_id,
                'country_id' => $facility->country_id,
                'city_id' => $facility->city_id,
                'email' => $facility->email,
                'fax' => $facility->fax,
                'bank_name' => $facility->bank_name,
                'bank_branch' => $facility->bank_branch,
                'iban' => $facility->iban,
                'payment_type' => $facility->payment_type,
                'active' => $facility->active,
                'benficiary' => $facility->benficiary,
                'facility_id' => $facility->id,
                'representative_name' => $facility->representative_name
            ];

            Log::info('Creating client trillion record');
            $clientTrillion = ClientTrillion::create($clientData);
            Log::info('Client trillion created:', ['client_trillion_id' => $clientTrillion->id]);

            // Create Contract
            $contractData = [
                'client_trillion_id' => $clientTrillion->id,
                'offer_id' => $offer->id,
                'type_id' => $offer->type_id,
                'start_date' => now(),
                'duration' => $offer->duration,
                'total_cost' => $offer->total_cost,
                'total_discount' => $offer->discount,
                'is_vat' => $offer->vat ? true : false,
                'approved_by_admin' => false, // Set default or based on your business logic
                'status_id' => $offer->status // Assuming this is the initial status
            ];

            Log::info('Creating contract record');
            $contract = Contract::create($contractData);
            Log::info('Contract created:', ['contract_id' => $contract->id]);

            // Get offer items and create contract items
            $offerItems = $offer->items;
            Log::info('Creating contract items from offer items:', ['items_count' => $offerItems->count()]);
            foreach ($offerItems as $offerItem) {
                // dd($offerItem);
                $contractItemData = [
                    'contract_id' => $contract->id,
                    'item_id' => $offerItem->item_id,
                    'cost' => $offerItem->cost,
                    'qty' => $offerItem->qty,
                    'discount' => $offerItem->discount,
                    'total_cost' => $offerItem->total_cost,
                    'notes' => $offerItem->notes
                ];

                ContractItem::create($contractItemData);
                Log::info('Contract item created:', [
                    'contract_id' => $contract->id,
                    'item_id' => $offerItem->item_id
                ]);
            }

            DB::commit();
            Log::info('Transaction committed successfully');

            return response()->json([
                'success' => true,
                'message' => t('Contract created successfully'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error(t('Error in add_contract process:'), [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'offer_id' => $offer->id,
                'facility_id' => $offer->facility_id ?? null
            ]);

            return response()->json([
                'error' => t('An error occurred while processing your request.'),
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function Offer(Request $request, $Id = null)
    {
        Log::info('Starting Offer function', [
            'request_data' => $request->all(),
            'offer_id' => $Id
        ]);

        try {
            DB::beginTransaction();

            // Validate request
            $validator = Validator::make($request->all(), [
                'facility_id' => 'required',
                // Add other validation rules as needed
            ]);

            if ($validator->fails()) {
                Log::warning('Offer validation failed', [
                    'errors' => $validator->errors()->toArray()
                ]);
                throw new ValidationException($validator);
            }
            Log::info('Request validation passed');

            // Process offer (create or update)
            if (isset($Id)) {
                Log::info('Updating existing offer', ['offer_id' => $Id]);
                $newOffer = Offer::findOrFail($Id);
                $newOffer->update($request->all());
                Log::info('Existing offer updated successfully', ['offer_id' => $Id]);
            } else {
                Log::info('Creating new offer');
                $newOffer = Offer::create($request->all());
                Log::info('New offer created successfully', ['new_offer_id' => $newOffer->id]);
            }

            // Update boolean fields
            $newOffer->vat = $request->vat_c === 'on' ? 1 : 0;
            $newOffer->wheels = $request->wheel_c === 'on' ? 1 : 0;
            $newOffer->active = $request->active_c === 'on' ? 1 : 0;
            $newOffer->save();

            Log::info('Boolean fields updated', [
                'offer_id' => $newOffer->id,
                'vat' => $newOffer->vat,
                'wheels' => $newOffer->wheels,
                'active' => $newOffer->active
            ]);

            DB::commit();
            Log::info('Transaction committed successfully');

            // Prepare response
            $message = 'Offer has been added successfully!';
            Log::info('Preparing response', [
                'is_ajax' => $request->ajax(),
                'offer_id' => $newOffer->id,
                'message' => $message
            ]);

            if ($request->ajax()) {
                $response = [
                    'status' => true,
                    'redirect' => route('offers.edit', ['offer' => $newOffer->id]) . "?active=items",
                    'message' => $message
                ];
                Log::info('Sending AJAX response', $response);
                return response()->json($response);
            }

            Log::info('Redirecting to offers index', [
                'offer_id' => $newOffer->id
            ]);

            return redirect()
                ->route('offers.index', [
                    'Id' => $newOffer->id,
                    'offer' => $newOffer->id
                ])
                ->with('status', $message);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error in Offer function:', [
                'errors' => $e->errors(),
                'offer_id' => $Id
            ]);
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in Offer function:', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'offer_id' => $Id
            ]);
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing your request',
                'debug_message' => $e->getMessage()
            ], 500);
        }
    }


    public function edit(Request $request, Offer $offer)
    {

        $countries = Country::all();
        $status = Constant::where('module', Modules::offer_module)->where('field', DropDownFields::offer_status)->get();
        $facilities = Facility::all();
        $company_types = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::facility_type)->get();
        $Types = Constant::where('module', Modules::offer_module)->where('field', DropDownFields::OFFER_TYPE)
            ->get();
        $pos_type = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::POS_TYPE)->get();
        $OSTYPES = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::OS_TYPE)->get();
        $type_id = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_TYPE)->get();
        $BANKS = Constant::where('module', Modules::CAPTIN)->where('field', DropDownFields::BANK)->get();
        $PAYMENTTYPES = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::PAYMENT_TYPE)->get();
        $preparation_time = DropDownFields::PREPARATION_TIME;
        $printer_type = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::printer_type)->get();
        $sys_satisfaction_rate = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::sys_satisfaction_rat)->get();
        $cities = City::all();
        $category_id = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::FACILITY_CATEGORY)->get();
        $titles = Constant::where('module', Modules::FACILITY)->where('field', DropDownFields::titles)->get();
        $facility = $offer->facility;
        $audits = $offer->audits()->with('user')->orderByDesc('created_at')->get();

        $attachmentAudits = Audit::whereHasMorph('auditable', Attachment::class, function ($query) use ($offer) {
            $query->where('attachable_type', offer::class)
                ->where('attachable_id', $offer->id)->withTrashed();
        })->with('user')->orderByDesc('created_at')->get();
        $createView = view(
            'offers.addedit',
            [

                'offer' => $offer,
                'facility' => $facility,
                'facilities' => $facilities,
                'status' => $status,
                'types' => $type_id,
                'countries' => $countries,
                'company_types' => $company_types,
                'cities' => $cities,
                'TYPES' => $Types,
                'OSTYPES' => $OSTYPES,
                'preparation_time' => $preparation_time,
                'BANKS' => $BANKS,
                'CATEGORYS' => $category_id,
                'printer_type' => $printer_type,
                'sys_satisfaction_rate' => $sys_satisfaction_rate,
                'titles' => $titles,
                'audits' => $audits,
                'attachmentAudits' => $attachmentAudits,
                'PAYMENT_TYPES' => $PAYMENTTYPES,
                'facilityTypes' => $type_id,
                'posTypes' => $pos_type
            ]
        )->render();


        return $createView;
        // return response()->json(['createView' => $createView]);
    }


    public function delete(Request $request, Offer $Offer)
    {
        $Offer->delete();
        return response()->json(['status' => true, 'message' => 'Offer Deleted Successfully !']);
    }

    public function export(Request $request)
    {
        /*$r= new OffersExport($request->all());
        return $r->view();*/
        return Excel::download(new OffersExport($request->all()), 'offers.xlsx');
    }


    public function viewCalls(Request $request, Offer $offer)
    {
        $income = CdrLog::where(DB::raw('RIGHT(cdr_logs.to,9)'), 'like', '%' . substr($offer->facility->telephone, -9) . '%')->get();
        $outcome = CdrLog::where(DB::raw('RIGHT(cdr_logs.from,9)'), 'like', '%' . substr($offer->facility->telephone, -9) . '%')->get();
        $sms = SystemSmsNotification::where(DB::raw('RIGHT(mobile,9)'), 'like', '%' . substr($offer->facility->telephone, -9) . '%')->get();
        $callsView = view(
            'offers.viewCalls',
            [
                'income' => $income,
                'outcome' => $outcome,
                'sms' => $sms,
                'offer' => $offer,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }

    public function sendEmail(Request $request, Offer $offer)
    {

        $callsView = view(
            'offers.sendEmail',
            [

                'offer' => $offer,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }

    public function printOffer(Request $request, Offer $offer)
    {
        $title = $offer->id;
        $path2 = public_path('cp'); // upload directory
        $data['font'] = \TCPDF_FONTS::addTTFfont($path2 . '/fonts/JannaBold.ttf', 'TrueTypeUnicode', '', '32');
        $fontname = \TCPDF_FONTS::addTTFfont($path2 . '/fonts/Janna.ttf', 'TrueTypeUnicode', '', '32');
        $pdf = new CustomPDFApp();
        $pdf->SetFont($fontname, '', 13, '', false);
        $pdf->reportTitle = $title;
        $pdf->reportNo = $offer->id;
        $pdf->reportDate = ' Date: ' . date('d/m/Y');
        $pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(30);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        /*  $pdf->setRTL(true);*/
        $pdf->AddPage();

        $data['offer'] = $offer;


        $htmlcontent2 = view('offers.printOffer', $data)->render();


        $pdf->WriteHTML($htmlcontent2);
        $path = public_path('uploads'); // upload directory
        return $pdf->Output($path . DIRECTORY_SEPARATOR . "offers/" . $title, 'I');
    }

    public function sendEmailTo(Request $request)
    {
        $offer = Offer::find($request->offer_id);
        $path2 = public_path('cp'); // upload directory
        $data['font'] = \TCPDF_FONTS::addTTFfont($path2 . '/fonts/JannaBold.ttf', 'TrueTypeUnicode', '', '32');
        $fontname = \TCPDF_FONTS::addTTFfont($path2 . '/fonts/Janna.ttf', 'TrueTypeUnicode', '', '32');
        $pdf = new CustomPDFApp();
        $pdf->SetFont($fontname, '', 14, '', false);
        $pdf->reportTitle = __('Offer');
        $pdf->reportNo = $offer->id;
        $pdf->reportDate = ' Date: ' . date('d/m/Y');
        $pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(30);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        /*  $pdf->setRTL(true);*/
        $pdf->AddPage();
        $title = $offer->id;
        $data['offer'] = $offer;
        $data['text'] = $request->text;


        $htmlcontent2 = view('offers.printOffer', $data)->render();


        $pdf->WriteHTML($htmlcontent2);
        $title = $title . \Illuminate\Support\Str::random(10) . ".pdf";
        $path = public_path('uploads'); // upload directory
        $pdf->Output($path . DIRECTORY_SEPARATOR . "offers/" . $title, 'F');

        Mail::send('offers.sendEmailText', $data, function ($message) use ($path, $offer, $pdf, $title, $request) {
            $message->from('trillionz@developon.co');
            $message->to($request->to);
            if ($request->cc)
                $message->cc($request->cc);
            // $message->cc('t.tamimi@developon.co');
            /*   $message->cc('l.alawy@tabibfind.ps');*/
            /*   if (EmployeeModel::find($salary->employee_id)->email)
                   $message->cc(EmployeeModel::find($salary->employee_id)->email);*/
            $message->subject($request->subject);
            $message->attach($path . DIRECTORY_SEPARATOR . "/offers/" . $title);;
        });


        return response()->json(['status' => true, 'message' => 'Offer Sent Successfully !']);
    }


    public function viewAttachments(Request $request, Offer $offer)
    {

        $callsView = view(
            'offers.attachments.indexP',
            [
                'offer' => $offer,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }

    public function viewItems(Request $request, Offer $offer)
    {

        $callsView = view(
            'offers.items.indexP',
            [
                'offer' => $offer,

            ]
        )->render();
        return response()->json(['createView' => $callsView]);
    }
}
