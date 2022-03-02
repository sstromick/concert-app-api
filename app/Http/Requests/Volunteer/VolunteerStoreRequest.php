<?php

namespace App\Http\Requests\Volunteer;

use Illuminate\Foundation\Http\FormRequest;

class VolunteerStoreRequest extends FormRequest
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
            'state_id' => 'integer|nullable',
            'country_id' => 'integer|nullable',
            'first_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'address_line_1' => 'string|nullable',
            'address_line_2' => 'string|nullable',
            'city' => 'string|nullable',
            'postal_code' => 'string|nullable',
            'country_text' => 'string|nullable',
            'state_text' => 'string|nullable',
            'email' => 'string|nullable',
            'phone' => 'string|nullable',
            'gender' => 'string|nullable',
            'tshirt_size' => 'string|nullable',
            'blocked' => 'boolean',
        ];
    }
}
