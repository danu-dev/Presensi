<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SubmitAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'notes' => ['nullable', 'string', 'max:1000'],
            'file'  => ['required', 'file', 'mimes:pdf,doc,docx,zip,png,jpg,jpeg', 'max:10240'],
        ];
    }
}
