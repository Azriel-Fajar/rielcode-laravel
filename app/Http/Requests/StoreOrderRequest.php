<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'package' => 'required|in:Student Plan,Starter Plan,Pro Plan,Premium Plan,Custom Plan',
            'domain' => 'nullable|in:Yes,No',
            'hosting' => 'nullable|in:Yes,No',
            'additional' => 'nullable|string|max:255',
            'free_promo' => 'nullable|boolean',
            'addons' => 'nullable|array',
            'addons.*' => 'nullable|integer|exists:package_addons,id',
        ];
    }
}
