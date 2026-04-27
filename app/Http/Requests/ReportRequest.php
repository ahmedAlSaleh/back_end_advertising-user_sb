<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'reportable_type' => ['required', 'string', 'in:advertisement,store,trader,post'],
            'reportable_id' => ['required', 'integer'],
            'reason' => ['required', 'string', 'in:spam,fraud,inappropriate,misleading,offensive,other'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'reportable_type.required' => 'Please specify what you are reporting',
            'reportable_type.in' => 'Invalid report type',
            'reportable_id.required' => 'Please specify the item to report',
            'reason.required' => 'Please select a reason for this report',
            'reason.in' => 'Invalid report reason',
        ];
    }
}
