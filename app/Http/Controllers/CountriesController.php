<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Requests\Country\CountryStoreRequest;
use App\Http\Requests\Country\CountryUpdateRequest;

class CountriesController extends Controller
{
    public function index() {
        $countries = Country::getFilteredCountries();
        return response()->json(['data' => $countries], 200);
    }

    public function store(CountryStoreRequest $request) {
        $attributes = $request->validated();
        $country = Country::create($attributes);
        return response()->json(['data' => $country, 'message' => 'Country created'], 201);
    }

    public function show(Country $country) {
        $country->states;
        return response()->json(['data' => $country], 200);
    }

    public function update(CountryUpdateRequest $request, Country $country) {
        $attributes = $request->validated();
        $country->update($attributes);
        $country->states;
        return response()->json(['data' => $country, 'message' => 'Country updated'], 200);
    }

    public function destroy(Country $country) {
        $country->delete();
        return response()->json(['data' => $country, 'message' => 'Country deleted'], 200);
    }

    public function export() {
        $countries = Country::getFilteredCountries();
        return $this->createExport($countries, "countries");
    }

    public function list() {
        $countries = Country::select('id', 'name', 'ISO2')->get();
        return response()->json(['data' => $countries], 200);
    }
}
