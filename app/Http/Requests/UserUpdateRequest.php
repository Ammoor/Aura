<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'profile_image' => ['sometimes', 'required', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'first_name' => ['sometimes', 'required', 'alpha', 'max:100'],
            'last_name' => ['sometimes', 'required', 'alpha', 'max:100'],
            'email' => ['sometimes', 'required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' =>  [
                'sometimes',
                'required',
                'confirmed',
                Password::min(8)
                    ->max(255)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised(),
                /*
                    - The password must be at least 8 characters and 255 at maximum.
                    - Has at least 1 uppercase letter.
                    - Has at least 1 lowercase letter.
                    - Has at least 1 number.
                    - Has not been compromised in data leaks.
                */
            ],
        ];
    }
}
