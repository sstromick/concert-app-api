<?php

namespace App\Http\Requests\NonProfit;

use Illuminate\Foundation\Http\FormRequest;

class NonProfitStoreRequest extends FormRequest
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
            'state_id' => 'required|integer',
            'country_id' => 'required|integer',
            'name' => 'string|nullable',
            'address_1' => 'string|nullable',
            'address_2' => 'string|nullable',
            'city' => 'string|nullable',
            'postal_code' => 'string|nullable',
            'country_text' => 'string|nullable',
            'state_text' => 'string|nullable',
            'website' => 'string|nullable',
        ];
    }
}
