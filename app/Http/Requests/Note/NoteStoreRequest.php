<?php

namespace App\Http\Requests\Note;

use Illuminate\Foundation\Http\FormRequest;

class NoteStoreRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'noteable_id' => 'required|integer',
            'noteable_type' => 'required|string',
            'content' => 'required|string',
        ];
    }
}
