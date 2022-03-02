<?php

namespace App\Http\Requests\Volunteer;

use Illuminate\Foundation\Http\FormRequest;

class VolunteerMergeRequest extends FormRequest {
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
