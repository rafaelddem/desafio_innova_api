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
            'username' => 'sometimes|between:3,20',
            'email' => 'prohibited',
            'password' => 'sometimes|string|min:6|confirmed',
            'hero_id' => 'sometimes|numeric|exists:heroes,id|unique:users,hero_id,' . auth()->user()->id,
            'role' => 'prohibited',
        ];
    }
}
