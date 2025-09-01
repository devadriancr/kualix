<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255|unique:users,nickname,'.$this->user->id,
            'email' => 'required|string|email|max:255',
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'area_id' => 'nullable|exists:areas,id',
            'roles' => 'sometimes|array',
            'roles.*' => 'exists:roles,id',
        ];
    }
}
