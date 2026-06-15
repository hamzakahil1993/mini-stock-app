<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique(Client::class)->ignore($this->route('client')),
            ],
            'phone' => ['nullable', 'string', 'max:50'],
            'status' => ['required', Rule::in([Client::STATUS_ACTIVE, Client::STATUS_INACTIVE])],
        ];
    }
}
