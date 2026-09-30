<?php

namespace App\Http\Requests;

use PixelFix\Framework\Http\Requests\FormRequest;

class StoreUserRequest extends FormRequest
{
    // =====================================================
    // AUTHORIZATION
    // =====================================================

    public function authorize(): bool
    {
        return true;
    }

    // =====================================================
    // VALIDATION RULES
    // =====================================================

    public function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'password_confirmation' => [
                'required',
                'string',
                'min:8',
            ],
        ];
    }

    // =====================================================
    // CUSTOM MESSAGES
    // =====================================================

    public function messages(): array
    {
        return [];
    }
}