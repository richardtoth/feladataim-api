<?php

namespace App\Http\Requests\Todo;

use App\TodoRequestEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            TodoRequestEnum::TITLE->value => ['sometimes', 'string', 'max:255'],
            TodoRequestEnum::DESCRIPTION->value => ['sometimes', 'nullable', 'string'],
            TodoRequestEnum::IS_COMPLETED->value => ['sometimes', 'boolean'],
            TodoRequestEnum::DUE_DATE->value => ['sometimes', 'nullable', 'date'],
        ];
    }
}
