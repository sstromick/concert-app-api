<?php

namespace App\Http\Requests\Venue;

use Illuminate\Foundation\Http\FormRequest;

class VenueUpdateRequest extends FormRequest
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
            'state_id' => 'integer',
            'country_id' => 'integer',
            'name' => 'string',
            'address_1' => 'string|nullable',
            'address_2' => 'string|nullable',
            'city' => 'string|nullable',
            'postal_code' => 'string|nullable',
            'country_text' => 'string|nullable',
            'state_text' => 'string|nullable',
            'website' => 'string|nullable',
            'phone' => 'string|nullable',
            'capacity' => 'integer|nullable',
            'compost' => 'boolean|nullable',
            'recycling_foh' => 'boolean|nullable',
            'recycling_single_stream_foh' => 'boolean|nullable',
            'recycling_sorted_foh' => 'boolean|nullable',
            'recycling_boh' => 'boolean|nullable',
            'recycling_single_stream_boh' => 'boolean|nullable',
            'recycling_sorted_boh' => 'boolean|nullable',
            'water_station' => 'boolean|nullable',
            'village_location' => 'string|nullable',
            'water_source' => 'string|nullable',
            'time_zone' => 'string|nullable',
        ];
    }
}
