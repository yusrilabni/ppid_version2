<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'email' => [
                'nullable', // Changed from 'required' to 'nullable'
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id, 'id'), // Restored unique rule
            ],
            // 'hobby' is removed as it's not a database column
            'bio' => ['nullable', 'string'], // bio column exists
            'facebook' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'string', 'max:255'], // Added rule for LinkedIn
            'photo' => ['nullable', 'image', 'max:2048'], // For handling the photo upload
            'nip' => ['nullable', 'string', 'max:255'],
        ];

        return $rules;
    }
}
