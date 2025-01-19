<?php

namespace App\Http\Controllers;

use App;
use App\Enums\DropDownFields;
use App\Models\Apartment;
use App\Models\Building;
use App\Models\MenuWebSite;
use App\Models\Service;
use App\Models\Feature;
use App\Models\Review;
use App\Models\WebsiteSection;
use App\Services\Constants\ConstantService;
use App\Services\Constants\GetConstantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


//use App\Models\RoleModel;

class MainController extends Controller
{

    public function index()
    {
        $data = [];
        return view('website.index', $data);
    }
    public function inquery()
    {

        if (\Session::has("success"))
            parent::$data["success"] = \Session::get("success");
        $lang = 2;

        //dd(LaravelLocalization::getCurrentLocale());
        if (LaravelLocalization::getCurrentLocale()  == 'en')
            $lang = 1;
        if (LaravelLocalization::getCurrentLocale()  == 'ar')
            $lang = 2;
        if (LaravelLocalization::getCurrentLocale()  == 'he')
            $lang = 3;


        self::$data['lang'] = $lang;
        self::$data['locale'] = \App::getLocale();
        self::$data['page-not-found-view'] = 'site.404';
        self::$data['cp_route_name'] = config('app.cp_route_name');
        self::$data['menu'] = MenuWebSite::all();
        // Get all lead form types at once
        parent::$data['leadFormTypes'] = ConstantService::search([
            'module' => 'lead_module',
            'field' => 'lead_form_type'
        ])->pluck('id', 'value')->toArray();

        // Add apartment sizes to the data array
        parent::$data['apartmentSizes'] = \App\Services\Constants\ConstantService::search([
            'module' => \App\Enums\Modules::appartment_module,
            'field' => \App\Enums\DropDownFields::apartment_size,
        ]);
        return view('website.inquery', parent::$data);
    }




    public function getBuildings()
    {
        try {
            $buildings = Building::with('city')
                ->select([
                    'id',
                    'name',
                    'floors_number',
                    'apartments_number',
                    'description',
                    'city_id',
                    // 'image',
                    // Add any other fields you need
                ])
                ->get()
                ->map(function ($building) {
                    return [
                        'id' => $building->id,
                        'name' => $building->name,
                        'floors' => $building->floors_number,
                        'totalUnits' => $building->apartments_number,
                        'description' => $building->description ?? t('No description'),
                        'location' => optional($building->city)->name,
                        'amenities' => [
                            // You can add your building amenities here
                            // For now using static data
                            'Infinity Pool',
                            'Sky Lounge',
                            'Smart Home Tech',
                            '24/7 Security'
                        ],
                        // Add a default image or get it from your storage
                        'buildingImage' => asset($building->image)
                    ];
                });

            return response()->json([
                'status' => 'success',
                'data' => $buildings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch buildings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getBuildingApartments($building_id)
    {
        try {
            $apartments = Apartment::with([
                'apartment_type',
                'apartment_size',
                'orientation',
                'parking_type'
            ])
                ->latest('updated_at')
                ->where('building_id', $building_id)
                ->limit(5)
                ->get()
                ->map(function ($apartment) {
                    $apartment['image'] = asset($apartment->image);

                    return $apartment;
                    // dd($apartment->id);
                    return [
                        'id' => $apartment->id,
                        'title' => $apartment->name,
                        'floor_name' => $apartment->floor_name,
                        'floor' => $apartment->floor_number,
                        'size' => ($apartment->apartment_size->name ?? '0') . ' sq.m',
                        'bedrooms' => $apartment->bedrooms_number,
                        'bathrooms' => $apartment->rooms_number,
                        'balcoines_number' => $apartment->balcoines_number,
                        'price' => '$' . number_format($apartment->price, 0),
                        'image' => asset($apartment->image),
                        'features' => [
                            optional($apartment->apartment_type)->name,
                            optional($apartment->orientation)->name,
                            optional($apartment->parking_type)->name
                        ],

                    ];
                });

            if ($apartments->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'data' => [],
                    'message' => 'No apartments available for this building'
                ]);
            }

            return response()->json([
                'status' => 'success',
                'data' => $apartments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch apartments',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
