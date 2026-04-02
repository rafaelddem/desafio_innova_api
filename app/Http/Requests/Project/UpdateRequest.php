<?php

namespace App\Http\Requests\User;

use App\Enums\Status;
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
            'name' => 'sometimes|between:3,20|regex:"^[A-Za-zÀ-ÖØ-öø-ÿç0-9\-.() ]+$"',
            'description' => 'sometimes|max:255|regex:"^[A-Za-zÀ-ÖØ-öø-ÿç0-9\-.() ]+$"',
            'status' => 'sometimes|in:' . implode(',', Status::values()),
            'goals' => 'sometimes|max:150|regex:"^[A-Za-zÀ-ÖØ-öø-ÿç0-9\-.() ]+$"',
            'user_id' => 'sometimes|exists:users,id',
        ];
    }
}
