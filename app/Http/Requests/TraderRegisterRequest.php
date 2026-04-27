<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TraderRegisterRequest extends FormRequest
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
            'store_name' => ['required', 'string', 'max:255'],
            'store_owner_name' => ['required', 'string', 'max:255'],
            'store_number' => ['required', 'string', 'max:20'],
            'sub_category_ids'    => 'required|array',
            'sub_category_ids.*'  => 'integer|exists:sub_categories,id',
            'owner_contact_number' => ['required', 'string', 'max:20', 'unique:traders,owner_contact_number'],
            'password' => ['required', 'string', 'min:8'],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'telegram_number' => ['nullable', 'string', 'max:20'],
            'city' => ['nullable', 'string'],
            'social_media_link' => ['nullable'],
            'image' => ['nullable'],
            'store_description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
