<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SubmitAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'location_id' => ['required', 'exists:locations,id'],
            'room_id'     => ['required', 'exists:rooms,id'],
            'latitude'    => ['required', 'numeric'],
            'longitude'   => ['required', 'numeric'],
            'type'        => ['required', 'in:check_in,check_out'],
        ];
    }
}
