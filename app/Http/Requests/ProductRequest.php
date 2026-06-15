<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'currency' => ['required', Rule::in(['EUR', 'CHF', 'USD', 'DZD'])],
            'quantity' => ['required', 'integer', 'min:0'],
        ];
    }
}
