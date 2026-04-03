<?php

namespace App\Http\Requests\Project;

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
            'name' => 'sometimes|between:3,20',
            'description' => 'sometimes|max:255',
            'status' => 'sometimes|in:' . implode(',', Status::values()),
            'goals' => 'sometimes|max:150',
            'user_id' => 'sometimes|exists:users,id',
        ];
    }
}
