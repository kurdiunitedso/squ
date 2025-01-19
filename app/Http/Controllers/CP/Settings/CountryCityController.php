<?php

namespace App\Http\Controllers\CP\Settings;

use App;
use App\Http\Controllers\Controller;
use App\Http\Requests\CP\CityRequest;
use App\Http\Requests\CP\CountryRequest;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Log;
use Yajra\DataTables\Facades\DataTables;

class CountryCityController extends Controller
{
    public function index(Request $request)
    {
        return view('constants.countrycity');
    }

    public function countries(Request $request)
    {
        $countries = Country::query()->latest();
        return   DataTables::eloquent($countries)
            ->editColumn('name', function ($country) {
                $flags  = $country->icon != null ? asset("" . $country->icon) : asset("media/.png");
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
            // ->editColumn('name', fn ($team) => $team->name)

            ->addColumn('action', function ($country) {
                return $country->action_buttons;
            })
            ->rawColumns(['name', 'action'])
            ->make();
    }



    public function country_create(Request $request)
    {
        $title = t('Add Country');
        $createView = view('constants.addedit_country_modal', compact('title'))->render();
        return response()->json(['createView' => $createView]);
    }

    public function country_store(CountryRequest $request)
    {
        $data = $request->except(['country_icon']);
        if ($request->has('country_icon') && $request->country_icon != "undefined") {
            $data['icon'] = uploadImage($request->file('country_icon'), 'flags');
        }
        if (isset($request->country_id)) {
            $country = Country::findOrFail($request->country_id);
            if ($request->has('country_icon') && $request->country_icon != "undefined") {
                deleteFile($country->icon);
            }
            $country->update($data);
            $message = t('country has been updated successfully!');
        } else {
            Country::create($data);
            $message = t('country has been created successfully!');
        }
        return response()->json(['status' => true, 'message' => $message]);
    }

    public function country_edit(Request $request, Country $country)
    {
        $title = t('Edit Country');
        $createView = view('constants.addedit_country_modal', ['country' => $country, 'title' => $title])->render();
        return response()->json(['createView' => $createView]);
    }


    public function country_delete(Request $request, Country $country)
    {
        $country->delete();
        deleteFile($country->icon);
        return response()->json(['status' => true, 'message' => $country->name . ' Deleted Successfully !']);
    }

    //City

    public function cities(Request $request)
    {
        $cities = City::with('country')->select('cities.*')->latest();
        return   DataTables::eloquent($cities)
            ->filter(function ($query) use ($request) {
                // Step 1: Check if there is a search value in the request
                if ($request->has('search') && $request->input('search.value') != '') {
                    $value = $request->input('search.value');
                    \Log::info('Search value detected', ['search_value' => $value]);

                    // Step 2: Fetch locales from the config file
                    $locales = config('app.locales');
                    \Log::info('Locales fetched from config', ['locales' => $locales]);

                    // Step 3: Apply the search filter
                    $query->where(function ($q) use ($value, $locales) {
                        // Step 3.1: Apply search to the 'name' field across different locales
                        $this->applyLocaleSearch($q, $value, $locales, 'name');

                        // Step 3.2: Apply search to related 'country' field
                        $q->orWhereHas('country', function ($q) use ($value, $locales) {
                            $this->applyLocaleSearch($q, $value, $locales, 'name');
                        });
                    });
                }
                \Log::info('Filter applied', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);
            })
            ->addColumn('action', function ($city) {
                return $city->action_buttons;
            })
            ->editColumn('name', fn($team) => $team->name)

            // ->rawColumns(['name', 'action'])
            ->make();
    }

    /**
     * Helper method to apply search across multiple locales
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string $value
     * @param array $locales
     * @param string $field
     */
    private function applyLocaleSearch($query, $value, $locales, $field)
    {
        foreach ($locales as $index => $locale) {
            \Log::info("Applying search for '$field' in locale", ['locale' => $locale, 'index' => $index]);

            if ($index === 0) {
                $query->whereRaw(
                    "json_extract(LOWER($field), \"$.$locale\") LIKE convert(? using utf8mb4) collate utf8mb4_general_ci",
                    ['%' . $value . '%']
                );
            } else {
                $query->orWhereRaw(
                    "json_extract(LOWER($field), \"$.$locale\") LIKE convert(? using utf8mb4) collate utf8mb4_general_ci",
                    ['%' . $value . '%']
                );
            }
        }
        \Log::info('Locale search applied', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);
    }
    public function city_create(Request $request)
    {
        $countries = Country::all();
        $title = t('Add City');
        $createView = view('constants.addedit_city_modal', ['countries' => $countries, 'title' => $title])->render();
        return response()->json(['createView' => $createView]);
    }

    public function city_store(CityRequest $request)
    {
        $data = $request->all();
        if (isset($request->city_id)) {
            $city = City::findOrFail($request->city_id);
            $city->update($data);
            $message = t('City has been updated successfully!');
        } else {
            City::create($data);
            $message = t('City has been created successfully!');
        }
        return response()->json(['status' => true, 'message' => $message]);
    }

    public function city_edit(Request $request, City $city)
    {
        $countries = Country::all();
        $title = t('Edit City');
        $createView = view('constants.addedit_city_modal', ['city' => $city, 'countries' => $countries, 'title' => $title])->render();
        return response()->json(['createView' => $createView]);
    }

    public function city_update(CityRequest $request, City $city)
    {
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
