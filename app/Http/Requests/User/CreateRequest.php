<?php

namespace App\Http\Requests\User;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|between:3,20|regex:"^[A-Za-zÀ-ÖØ-öø-ÿç0-9\-.() ]+$"',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'character' => 'required|between:3,20|regex:"^[A-Za-zÀ-ÖØ-öø-ÿç0-9\-.() ]+$"',
            'role' => 'required|in:' . implode(',', Role::values()),
        ];
    }
}
