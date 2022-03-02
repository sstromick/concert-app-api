<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Metric;
use Illuminate\Http\Request;
use App\Http\Requests\Metric\MetricStoreRequest;
use App\Http\Requests\Metric\MetricUpdateRequest;

class MetricsController extends Controller
{
    public function index() {
        $metrics = Metric::getFilteredMetrics();
        return response()->json(['data' => $metrics], 200);
    }

    public function noPaginate() {
        $metrics = Metric::getFilteredMetrics(true);
        return response()->json(['data' => $metrics], 200);
    }

    public function store(MetricStoreRequest $request) {
        $attributes = $request->validated();
        $metric = Metric::create($attributes);
        return response()->json(['data' => $metric, 'message' => 'Metric created'], 201);
    }

    public function show(Metric $metric) {
        return response()->json(['data' => $metric], 200);
    }

    public function update(MetricUpdateRequest $request, Metric $metric) {
        $attributes = $request->validated();
        $metric->update($attributes);
        return response()->json(['data' => $metric, 'message' => 'Metric updated'], 200);
    }

    public function destroy(Metric $metric) {
        $metric->delete();
        return response()->json(['data' => $metric, 'message' => 'Metric deleted'], 200);
    }

}
