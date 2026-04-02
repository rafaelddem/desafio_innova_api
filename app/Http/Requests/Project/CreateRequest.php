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
            'name' => 'required|between:3,20|regex:"^[A-Za-zÀ-ÖØ-öø-ÿç0-9\-.() ]+$"',
            'description' => 'required|max:255|regex:"^[A-Za-zÀ-ÖØ-öø-ÿç0-9\-.() ]+$"',
            'status' => 'required|in:' . implode(',', Status::values()),
            'goals' => 'required|max:150|regex:"^[A-Za-zÀ-ÖØ-öø-ÿç0-9\-.() ]+$"',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
