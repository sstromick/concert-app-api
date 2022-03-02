<?php

namespace App\Http\Requests\Artist;

use Illuminate\Foundation\Http\FormRequest;

class ArtistUploadPhotoRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'photo_url' => 'image|required',
        ];
    }
}
