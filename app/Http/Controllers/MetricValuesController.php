<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetricValue;
use App\Http\Requests\MetricValue\MetricValueStoreRequest;
use App\Http\Requests\MetricValue\MetricValueUpdateRequest;
use Log;
use DB;

class MetricValuesController extends Controller
{
    public function index() {
        $metricValues = MetricValue::getFilteredMetricValues();
        return response()->json(['data' => $metricValues], 200);
    }

    public function noPaginate() {
        $metricValues = MetricValue::getFilteredMetricValues(true);
        return response()->json(['data' => $metricValues], 200);
    }

    public function store(MetricValueStoreRequest $request) {
        $attributes = $request->validated();

        $metricValue = MetricValue::where('metric_id', '=', $attributes['metric_id'])->first();
        if ($metricValue) {
            $attributes['value'] = $attributes['value'] + $metricValue->value;
            $metricValue->update($attributes);
            return response()->json(['data' => $metricValue, 'message' => 'Metric Value updated'], 200);
        }
        else {
            $metricValue = MetricValue::create($attributes);
            return response()->json(['data' => $metricValue, 'message' => 'Metric Value created'], 201);
        }
    }

    public function updateMetrics(Request $request) {
        $attributes = $request->validate([
            "metrics"    => "array",
            "metrics.metric_id"  => "integer",
            "metrics.metricable_id"  => "integer",
            "metrics.metricable_type"  => "string",
            "metrics.name"  => "string",
            "metrics.value"  => "integer",
        ]);

        if ($request['metrics']) {
            foreach($request['metrics'] as $item)
            {

                DB::table('metric_values')
                    ->updateOrInsert(
                        ['metric_id' => $item['metric_id'], 'metricable_id' => $item['metricable_id'], 'metricable_type' => $item['metricable_type']],
                        ['value' => $item['value']]
                    );

            }
        }

        return response()->json(['data' => $attributes, 'message' => 'Metrics Updted'], 200);

    }

    public function show(MetricValue $metricValue) {
        return response()->json(['data' => $metricValue], 200);
    }

    public function update(MetricValueUpdateRequest $request, MetricValue $metricValue) {
        $attributes = $request->validated();
        $metricValue->update($attributes);
        return response()->json(['data' => $metricValue, 'message' => 'Metric Value updated'], 200);
    }

    public function destroy(MetricValue $metricValue) {
        $metricValue->delete();
        return response()->json(['data' => $metricValue, 'message' => 'Metric Value deleted'], 200);
    }

}
