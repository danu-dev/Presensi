<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user') instanceof \App\Models\User 
            ? $this->route('user')->id 
            : $this->route('user');

        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email,' . $userId],
            'password' => ['nullable', 'min:6'],
            'role'     => ['required', 'in:user,guru,admin'],
        ];

        if ($this->input('role') === 'user') {
            $rules['nisn'] = ['required', 'string', 'unique:users,nisn,' . $userId, 'digits:10'];
        } else {
            $rules['nisn'] = ['nullable', 'string', 'unique:users,nisn,' . $userId, 'digits:10'];
        }

        return $rules;
    }
}
