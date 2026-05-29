<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:30',
            'email' => 'required|email|max:50',
            'phone' => 'required|string|max:13',
            'custom_total' => 'required|integer|min:500000',
            'custom_preset' => 'required|in:blank,copy',
            'copy_source_url' => 'nullable|url|max:500|required_if:custom_preset,copy',
            'custom_config' => 'nullable|string',
            'domain' => 'nullable|in:Yes,No',
            'hosting' => 'nullable|in:Yes,No',
        ];
    }
}
