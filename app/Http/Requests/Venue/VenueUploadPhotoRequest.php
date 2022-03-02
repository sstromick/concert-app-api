<?php

namespace App\Http\Requests\Venue;

use Illuminate\Foundation\Http\FormRequest;

class VenueUploadPhotoRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'photo_url' => 'image|required',
        ];
    }
}
