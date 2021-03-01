<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CityStoreRequest;
use App\Http\Requests\Api\CityUpdateRequest;
use App\Http\Resources\Api\CityCollection;
use App\Http\Resources\Api\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\Api\CityCollection
     */
    public function index(Request $request)
    {
        $cities = City::all();

        return new CityCollection($cities);
    }

    /**
     * @param \App\Http\Requests\Api\CityStoreRequest $request
     * @return \App\Http\Resources\Api\CityResource
     */
    public function store(CityStoreRequest $request)
    {
        $city = City::create($request->validated());

        return new CityResource($city);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\City $city
     * @return \App\Http\Resources\Api\CityResource
     */
    public function show(Request $request, City $city)
    {
        return new CityResource($city);
    }

    /**
     * @param \App\Http\Requests\Api\CityUpdateRequest $request
     * @param \App\Models\City $city
     * @return \App\Http\Resources\Api\CityResource
     */
    public function update(CityUpdateRequest $request, City $city)
    {
        $city->update($request->validated());

        return new CityResource($city);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, City $city)
    {
        $city->delete();

        return response()->noContent();
    }
}
