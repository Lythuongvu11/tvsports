<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
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
            'name' => 'required',
            'display_name' => 'required',
            'group' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Trường tên là bắt buộc.',
            'display_name.required' => 'Trường tên hiển thị là bắt buộc.',
            'group.required' => 'Trường nhóm là bắt buộc.',
        ];
    }
}
