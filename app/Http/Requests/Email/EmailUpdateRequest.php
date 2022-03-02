<?php

namespace App\Http\Requests\Email;

use Illuminate\Foundation\Http\FormRequest;

class EmailUpdateRequest extends FormRequest
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
            'event_id' => 'integer|nullable',
            'email_template_id' => 'integer|nullable',
            'nonprofit_shift_id' => 'integer|nullable',
            'volunteer_shift_id' => 'integer|nullable',
            'email' => 'string|nullable',
            'subject' => 'string|nullable',
            'body' => 'string|nullable',
            'delivered' => 'boolean',
            'error' => 'string|nullable',
        ];
    }
}
