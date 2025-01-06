<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CountryCityController extends Controller
{
    public function index(Request $request)
    {
        return view('constants.countrycity');
    }

    public function countries(Request $request)
    {
        $countries = Country::query();
        return   DataTables::eloquent($countries)
            ->editColumn('name', function ($country) {
                $flags  = $country->icon != null ? asset("flags/" . $country->icon) : asset("media/.png");
                $template = '
                            <!--begin:: Avatar -->
                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                <a href="#">
                                    <div class="symbol-label">
                                        <img src="' . $flags . '" alt="' . $country->name . '" class="w-100">
                                    </div>
                                </a>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::country details-->
                            <div class="d-flex flex-column">
                                <a href="#"
                                    class="text-gray-800 text-hover-primary mb-1">' . $country->name . '</a>
                                <span>' . $country->email . '</span>
                            </div>
                            <!--begin::country details-->
                        ';
                return $template;
            })
            ->addColumn('action', function ($country) {
                $editBtn = '<a href="' . route('settings.country-city.country.edit', ['country' => $country->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdatecountry">
            <span class="svg-icon svg-icon-3">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
            <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
            <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
            </svg>
            </span>
            </a>';
                $removeBtn = '<a data-country-name="' . $country->name . '" href="' . route('settings.country-city.country.delete', ['country' => $country->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeletecountry"
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
                return $editBtn . $removeBtn;
            })
            ->rawColumns(['name', 'action'])
            ->make();
    }
    public function cities(Request $request)
    {
        $cities = City::with('country')->select('cities.*');
        return   DataTables::eloquent($cities)
            ->addColumn('action', function ($city) {
                $editBtn = '<a href="' . route('settings.country-city.city.edit', ['city' => $city->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnUpdateCity">
            <span class="svg-icon svg-icon-3">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="currentColor"/>
            <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="currentColor"/>
            <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="currentColor"/>
            </svg>
            </span>
            </a>';
                $removeBtn = '<a data-city-name="' . $city->name . '" href="' . route('settings.country-city.city.delete', ['city' => $city->id]) . '" class="btn btn-icon btn-active-light-primary w-30px h-30px btnDeleteCity"
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
                return $editBtn . $removeBtn;
            })
            ->rawColumns(['name', 'action'])
            ->make();
    }


    public function country_create(Request $request)
    {
        $createView = view('constants.addedit_country_modal')->render();
        return response()->json(['createView' => $createView]);
    }

    public function country_store(Request $request)
    {
        $request->validate([
            'country_name' => 'required|string',
            'country_code' => 'required|string|max:2',
            'country_icon' => 'required|file',
        ]);

        $country = new Country();
        $country->name = $request->country_name;
        $country->code = $request->country_code;

        $request->country_icon->store('flags');
        $country->icon = $request->country_icon->hashName();

        $country->save();

        return response()->json(['status' => true, 'message' => 'country has been added successfully!']);
    }

    public function country_edit(Request $request, Country $country)
    {
        $createView = view('constants.addedit_country_modal', ['country' => $country])->render();
        return response()->json(['createView' => $createView]);
    }

    public function country_update(Request $request, Country $country)
    {
        $request->validate([
            'country_name' => 'required|string',
            'country_code' => 'required|string|max:2',
        ]);

        $country->name = $request->country_name;
        $country->code = $request->country_code;

        if ($request->country_icon != "undefined") {
            $request->country_icon->store('flags');
            $country->icon = $request->country_icon->hashName();
        }

        $country->save();

        return response()->json(['status' => true, 'message' => $country->name . ' Updated']);
    }

    public function country_delete(Request $request, Country $country)
    {
        $country->delete();
        return response()->json(['status' => true, 'message' => $country->name . ' Deleted Successfully !']);
    }

    //City

    public function city_create(Request $request)
    {
        $countries = Country::all();
        $createView = view('constants.addedit_city_modal', ['countries' => $countries])->render();
        return response()->json(['createView' => $createView]);
    }

    public function city_store(Request $request)
    {
        $request->validate([
            'city_name' => 'required|string',
            'city_country_id' => 'required|integer',
        ]);

        $city = new City();

        $city->name = $request->city_name;
        $city->name_en = $request->name_en;
        $city->country_id = $request->city_country_id;

        $city->save();

        return response()->json(['status' => true, 'message' => 'city has been added successfully!']);
    }

    public function city_edit(Request $request, City $city)
    {
        $countries = Country::all();
        $createView = view('constants.addedit_city_modal', ['city' => $city, 'countries' => $countries])->render();
        return response()->json(['createView' => $createView]);
    }

    public function city_update(Request $request, City $city)
    {
        $request->validate([
            'city_name' => 'required|string',
            'city_country_id' => 'required|integer',
        ]);

        $city->name = $request->city_name;
        $city->name_en = $request->name_en;
        $city->country_id = $request->city_country_id;

        $city->save();

        return response()->json(['status' => true, 'message' => $city->name . ' Updated']);
    }

    public function city_delete(Request $request, City $city)
    {
        $city->delete();
        return response()->json(['status' => true, 'message' => $city->name . ' Deleted Successfully !']);
    }

    public function getCountryCities(Request $request, Country $country)
    {
        $cities = City::where('country_id', $country->id)->get();

        $result = [];

        foreach ($cities as $city) {
            array_push($result, ["id" => $city->id, "text" => $city->name]);
        }

        return response()->json(['results' => $result]);
    }
}
