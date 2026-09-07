<?php

namespace App\Http\Requests\Guru;

use Illuminate\Foundation\Http\FormRequest;

class SubmitManualAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id'       => ['required', 'exists:rooms,id'],
            'date'          => ['required', 'date'],
            'attendances'   => ['required', 'array'],
            'attendances.*' => ['in:present,permission,absent'],
        ];
    }
}
