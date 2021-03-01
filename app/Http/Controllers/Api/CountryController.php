<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CountryStoreRequest;
use App\Http\Requests\Api\CountryUpdateRequest;
use App\Http\Resources\Api\CountryCollection;
use App\Http\Resources\Api\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\Api\CountryCollection
     */
    public function index(Request $request)
    {
        $countries = Country::all();

        return new CountryCollection($countries);
    }

    /**
     * @param \App\Http\Requests\Api\CountryStoreRequest $request
     * @return \App\Http\Resources\Api\CountryResource
     */
    public function store(CountryStoreRequest $request)
    {
        $country = Country::create($request->validated());

        return new CountryResource($country);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Country $country
     * @return \App\Http\Resources\Api\CountryResource
     */
    public function show(Request $request, Country $country)
    {
        return new CountryResource($country);
    }

    /**
     * @param \App\Http\Requests\Api\CountryUpdateRequest $request
     * @param \App\Models\Country $country
     * @return \App\Http\Resources\Api\CountryResource
     */
    public function update(CountryUpdateRequest $request, Country $country)
    {
        $country->update($request->validated());

        return new CountryResource($country);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Country $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Country $country)
    {
        $country->delete();

        return response()->noContent();
    }
}
