<?php

namespace App\Http\Requests\Venue;

use Illuminate\Foundation\Http\FormRequest;

class VenueMergeRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            "id"  => "required|integer",
            "destination_id"    => "required|integer",
            "overwrite"  => "required|boolean",
        ];
    }
}
