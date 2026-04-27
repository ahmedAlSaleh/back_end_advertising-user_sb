<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateTraderProfileRequest extends FormRequest
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
            'store_name'           => ['nullable', 'string', 'max:255'],
            'store_owner_name'     => ['nullable', 'string', 'max:255'],
            'store_number'         => ['nullable', 'string', 'max:20'],
            'sub_category_ids'   => 'sometimes|array',
            'sub_category_ids.*' => 'integer|exists:sub_categories,id',
            'owner_contact_number' => ['nullable', 'string', 'max:20'],
            'whatsapp_number'      => ['sometimes', 'nullable', 'string', 'max:20'],
            'telegram_number'      => ['sometimes', 'nullable', 'string', 'max:20'],
            'social_media_link'    => ['sometimes', 'nullable', 'url'],  // make sure it's a valid URL
            'image'                => ['sometimes', 'nullable', 'file', 'image', 'max:2048'],
            'store_description'    => ['sometimes', 'nullable', 'string', 'max:500'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors(),
        ], 422));
    }
}
