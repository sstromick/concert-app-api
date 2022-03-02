<?php

namespace App\Http\Requests\NonProfit;

use Illuminate\Foundation\Http\FormRequest;

class NonProfitUploadPhotoRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'photo_url' => 'image|required',
        ];
    }
}
