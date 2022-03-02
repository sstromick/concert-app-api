<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'artist_id' => 'integer|nullable',
            'venue_id' => 'integer',
            'name' => 'required|string',
            'passive' => 'boolean',
            'teams' => 'boolean',
            'contact_name' => 'string|nullable',
            'contact_email' => 'string|nullable',
            'contact_phone' => 'string|nullable',
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'CO2_artist_tonnes' => 'numeric|between:0,999999.99|nullable',
            'CO2_fans_tonnes' => 'numeric|between:0,999999.99|nullable',
        ];
    }
}
