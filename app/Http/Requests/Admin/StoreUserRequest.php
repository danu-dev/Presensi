<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'role'     => ['required', 'in:user,guru,admin'],
        ];

        if ($this->input('role') === 'user') {
            $rules['nisn'] = ['required', 'string', 'unique:users,nisn', 'digits:10'];
        } else {
            $rules['nisn'] = ['nullable', 'string', 'unique:users,nisn', 'digits:10'];
        }

        return $rules;
    }
}
