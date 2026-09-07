<?php

namespace App\Http\Requests\Guru;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id'     => ['required', 'exists:rooms,id'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date'    => ['required', 'date', 'after:now'],
            'file'        => ['nullable', 'file', 'mimes:pdf,doc,docx,zip,png,jpg,jpeg', 'max:10240'],
        ];
    }
}
