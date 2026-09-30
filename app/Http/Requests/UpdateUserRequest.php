<?php

namespace App\Http\Requests;

use PixelFix\Framework\Http\Requests\FormRequest;

class UpdateUserRequest extends FormRequest
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
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
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