<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdsRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'price' => 'required|max:255',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif',
            'type' => 'required|in:normal,special',
            'scheduled_at' => 'nullable|date|after:now',
            'expires_at' => 'nullable|date|after:scheduled_at',
        ];
    }

    public function messages(): array
    {
        return [
            'scheduled_at.after' => 'Scheduled date must be in the future',
            'expires_at.after' => 'Expiration date must be after scheduled date',
        ];
    }
}
