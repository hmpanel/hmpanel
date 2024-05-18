<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FtpAccountStoreRequest extends FormRequest
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
            'username' => ['required', 'max:255', 'string'],
            'password' => ['required'],
            'web_app_id' => ['required', 'exists:web_apps,id'],
        ];
    }
}
