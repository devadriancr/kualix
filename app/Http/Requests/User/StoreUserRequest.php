<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()

    {
        return [
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255',
            'password' => ['required', 'confirmed', Password::min(8)],
            'area_id' => 'required|exists:areas,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ];
    }
}
