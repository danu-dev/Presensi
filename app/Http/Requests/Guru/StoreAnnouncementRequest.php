<?php

namespace App\Http\Requests\Guru;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'urgency'     => ['required', 'in:low,medium,high'],
            'expires_at'  => ['nullable', 'date', 'after_or_equal:today'],
            'room_id'     => ['nullable', 'exists:rooms,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'            => 'Judul pengumuman harus diisi.',
            'description.required'      => 'Isi pengumuman harus diisi.',
            'urgency.required'          => 'Tingkat urgensi harus dipilih.',
            'expires_at.after_or_equal' => 'Tanggal kadaluarsa tidak boleh sebelum hari ini.',
            'room_id.exists'            => 'Ruangan yang dipilih tidak valid.',
        ];
    }
}
