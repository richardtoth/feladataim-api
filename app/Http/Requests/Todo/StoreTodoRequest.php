<?php

namespace App\Http\Requests\Todo;

use App\TodoRequestEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
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
            TodoRequestEnum::TITLE->value => ['required', 'string', 'max:255'],
            TodoRequestEnum::DESCRIPTION->value => ['nullable', 'string'],
            TodoRequestEnum::DUE_DATE->value => ['nullable', 'date'],
        ];
    }
}
