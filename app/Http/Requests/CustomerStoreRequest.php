<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['nullable'],
            'first_name' => ['required', 'max:255', 'string'],
            'last_name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string'],
            'bank_account_number' => ['required', 'numeric'],
            'about' => ['nullable', 'string', 'max:500']


        ];
    }
}
