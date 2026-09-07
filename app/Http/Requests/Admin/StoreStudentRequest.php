<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'image'         => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'role'          => ['required', 'string', 'max:255'],
            'github_url'    => ['nullable', 'url'],
            'linkedin_url'  => ['nullable', 'url'],
            'instagram_url' => ['nullable', 'url'],
        ];
    }
}
