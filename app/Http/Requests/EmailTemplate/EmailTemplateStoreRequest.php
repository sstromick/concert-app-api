<?php

namespace App\Http\Requests\EmailTemplate;

use Illuminate\Foundation\Http\FormRequest;

class EmailTemplateStoreRequest extends FormRequest
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
            'event_id' => 'required|integer',
            'shift_id' => 'integer|nullable',
            'subject' => 'string|nullable',
            'body' => 'string|nullable',
            'event_type' => 'string|nullable',
        ];
    }
}
