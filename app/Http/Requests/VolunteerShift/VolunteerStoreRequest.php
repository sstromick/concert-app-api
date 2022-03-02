<?php

namespace App\Http\Requests\VolunteerShift;

use Illuminate\Foundation\Http\FormRequest;

class VolunteerShiftStoreRequest extends FormRequest
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
            'event_id' => 'integer',
            'volunteer_id' => 'integer',
            'attended' => 'boolean',
            'waitlist' => 'boolean',
            'accepted' => 'boolean',
            'declined' => 'boolean',
            'pending' => 'boolean',
            'confirmed' => 'boolean',
            'roll_call' => 'string|nullable',
            'state_id' => 'integer',
            'country_id' => 'integer',
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
            'note' => 'string|nullable',
        ];
    }
}
