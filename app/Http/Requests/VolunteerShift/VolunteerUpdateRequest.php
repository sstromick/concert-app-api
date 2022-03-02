<?php

namespace App\Http\Requests\VolunteerShift;

use Illuminate\Foundation\Http\FormRequest;

class VolunteerShiftUpdateRequest extends FormRequest
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
            'volunteer_id' => 'integer',
            'attended' => 'boolean',
            'waitlist' => 'boolean',
            'accepted' => 'boolean',
            'declined' => 'boolean',
            'pending' => 'boolean',
            'confirmed' => 'boolean',
            'roll_call' => 'string|nullable',
            'note' => 'string|nullable',
        ];
    }
}
