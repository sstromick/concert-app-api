<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Http\Requests\State\StateStoreRequest;
use App\Http\Requests\State\StateUpdateRequest;

class StatesController extends Controller
{
    public function index() {
        $states = State::getFilteredStates();
        return response()->json(['data' => $states], 200);
    }

    public function store(StateStoreRequest $request) {
        $attributes = $request->validated();
        $state = State::create($attributes);
        return response()->json(['data' => $state, 'message' => 'State created'], 201);
    }

    public function show(State $state) {
        return response()->json(['data' => $state], 200);
    }

    public function update(StateUpdateRequest $request, State $state) {
        $attributes = $request->validated();
        $state->update($attributes);
        return response()->json(['data' => $state, 'message' => 'State updated'], 200);
    }

    public function destroy(State $state) {
        $state->delete();
        return response()->json(['data' => $state, 'message' => 'State deleted'], 200);
    }

    public function export() {
        $states = State::getFilteredStates();
        return $this->createExport($states, "states");
    }

    public function list() {
        $states = State::select('id', 'country_id', 'name', 'abbreviation')->get();
        return response()->json(['data' => $states], 200);
    }
}
