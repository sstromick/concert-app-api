<?php

namespace App\Http\Requests\Metric;

use Illuminate\Foundation\Http\FormRequest;

class MetricUpdateRequest extends FormRequest
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
            'active' => 'boolean',
            'name' => 'string',
            'metric_type' => ["string"],
            'active' => 'boolean',
        ];
    }
}
