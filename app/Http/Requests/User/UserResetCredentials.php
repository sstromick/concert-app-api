<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class UserResetCredentials extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name' => 'string',
            'email' => 'unique:users,email,' . $this->id . ',id,deleted_at,NULL',
            'password'  => ''
        ];
    }
}
