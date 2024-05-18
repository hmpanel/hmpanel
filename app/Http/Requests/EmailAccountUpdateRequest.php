<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailAccountUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['nullable'],
            'web_app_id' => ['required', 'exists:web_apps,id'],
        ];
    }
}
