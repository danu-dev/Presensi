<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SubmitPermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'date'        => ['required', 'date', 'after_or_equal:today'],
            'proof_image' => ['required', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'             => 'Nama izin harus diisi.',
            'description.required'      => 'Deskripsi harus diisi.',
            'date.required'             => 'Tanggal harus diisi.',
            'date.after_or_equal'       => 'Tanggal tidak boleh sebelum hari ini.',
            'proof_image.required'      => 'Bukti gambar harus diunggah.',
            'proof_image.image'         => 'File harus berupa gambar.',
            'proof_image.max'           => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
