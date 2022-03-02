<?php

namespace App\Http\Requests\MetricValue;

use Illuminate\Foundation\Http\FormRequest;

class MetricValueStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'metric_id' => 'required|integer',
            'metricable_id' => 'required|integer',
            'metricable_type' => 'required|string',
            'value' => 'numeric|between:0,9999999.99|nullable',
        ];
    }
}
