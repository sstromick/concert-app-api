<?php

namespace App\Http\Requests\Shift;

use Illuminate\Foundation\Http\FormRequest;

class ShiftStoreRequest extends FormRequest
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
            'artist_id' => 'integer|nullable',
            'venue_id' => 'integer|nullable',
            'name' => 'string|nullable',
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'doors' => 'nullable',
            'check_in' => 'nullable',
            'hours_worked' => 'numeric|between:0,999999.99|nullable',
            'volunteer_cap' => 'integer|nullable',
            'item' => 'string|nullable',
            'item_sold' => 'numeric|between:0,999999.99|nullable',
            'item_bof_free' => 'numeric|between:0,999999.99|nullable',
            'item_revenue_cash' => 'numeric|between:0,999999.99|nullable',
            'item_revenue_cc' => 'numeric|between:0,999999.99|nullable',
            'biod_gallons' => 'numeric|between:0,999999.99|nullable',
            'compost_gallons' => 'numeric|between:0,999999.99|nullable',
            'water_foh_gallons' => 'numeric|between:0,999999.99|nullable',
            'water_boh_gallons' => 'numeric|between:0,999999.99|nullable',
            'farms_supported' => 'integer|nullable',
            'tickets_sold' => 'numeric|between:0,999999.99|nullable',
        ];
    }
}
