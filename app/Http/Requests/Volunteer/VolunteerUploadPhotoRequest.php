<?php

namespace App\Http\Requests\Volunteer;

use Illuminate\Foundation\Http\FormRequest;

class VolunteerUploadPhotoRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'photo_url' => 'image|required',
        ];
    }
}
