<?php

namespace App\Http\Requests\Project;

use App\Enums\Status;
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
            'name' => 'required|between:3,20',
            'description' => 'required|max:255',
            'status' => 'required|in:' . implode(',', Status::values()),
            'goals' => 'required|max:150',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
