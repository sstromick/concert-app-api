<?php

namespace App\Http\Requests\NonProfitShift;

use Illuminate\Foundation\Http\FormRequest;

class NonProfitShiftUpdateRequest extends FormRequest
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
            'shift_id' => 'integer',
            'non_profit_id' => 'integer',
            'contact_name' => 'string|nullable',
            'email' => 'string|nullable',
            'phone' => 'string|nullable',
            'item' => 'string|nullable',
            'item_actions' => 'numeric|between:0,999999.99|nullable',
        ];
    }
}
