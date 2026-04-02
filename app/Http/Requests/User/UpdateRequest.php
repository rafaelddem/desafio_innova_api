<?php

namespace App\Http\Requests\User;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'sometimes|between:3,20|regex:"^[A-Za-zÀ-ÖØ-öø-ÿç0-9\-.() ]+$"',
            'email' => 'prohibited',
            'password' => 'sometimes|string|min:6|confirmed',
            'hero_id' => 'sometimes|numeric|unique:users,hero_id|exists:heroes,id',
            'role' => 'sometimes|in:' . implode(',', Role::values()),
        ];
    }
}
