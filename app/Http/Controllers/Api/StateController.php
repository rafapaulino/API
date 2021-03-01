<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StateStoreRequest;
use App\Http\Requests\Api\StateUpdateRequest;
use App\Http\Resources\Api\StateCollection;
use App\Http\Resources\Api\StateResource;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\Api\StateCollection
     */
    public function index(Request $request)
    {
        $states = State::all();

        return new StateCollection($states);
    }

    /**
     * @param \App\Http\Requests\Api\StateStoreRequest $request
     * @return \App\Http\Resources\Api\StateResource
     */
    public function store(StateStoreRequest $request)
    {
        $state = State::create($request->validated());

        return new StateResource($state);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\State $state
     * @return \App\Http\Resources\Api\StateResource
     */
    public function show(Request $request, State $state)
    {
        return new StateResource($state);
    }

    /**
     * @param \App\Http\Requests\Api\StateUpdateRequest $request
     * @param \App\Models\State $state
     * @return \App\Http\Resources\Api\StateResource
     */
    public function update(StateUpdateRequest $request, State $state)
    {
        $state->update($request->validated());

        return new StateResource($state);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\State $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, State $state)
    {
        $state->delete();

        return response()->noContent();
    }
}
