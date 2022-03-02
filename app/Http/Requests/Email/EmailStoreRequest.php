<?php

namespace App\Http\Requests\Email;

use Illuminate\Foundation\Http\FormRequest;

class EmailStoreRequest extends FormRequest
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
            'event_id' => 'integer',
            'email_template_id' => 'integer',
            'non_profit_shift_id' => 'integer',
            'volunteer_shift_id' => 'integer',
            'email' => 'required|string',
            'subject' => 'required|string|nullable',
            'body' => 'required|string|nullable',
            'delivered' => 'boolean',
            'error' => 'string|nullable',
        ];
    }
}
