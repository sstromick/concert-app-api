<?php

namespace App\Http\Requests\ShiftSchedule;

use Illuminate\Foundation\Http\FormRequest;

class ShiftScheduleStoreRequest extends FormRequest
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
            'shift_id' => 'required|integer',
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'doors' => 'nullable',
            'check_in' => 'nullable',
        ];
    }
}
