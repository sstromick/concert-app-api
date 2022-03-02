<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventUploadPhotoRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'photo_url' => 'image|required',
        ];
    }
}
