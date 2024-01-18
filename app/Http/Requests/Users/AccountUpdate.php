<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class AccountUpdate extends FormRequest
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
            'birthday' => 'required|date_format:Y-m-d',
            'gender' => 'required',
            'password' => 'nullable|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Trường tên là bắt buộc.',
            'birthday.required' => 'Trường ngày sinh là bắt buộc.',
            'password.required' => 'Trường mật khẩu là bắt buộc.',
            'password.min' => 'Trường mật khẩu phải có ít nhất 6 ký tự.',
            'avatar.image' => 'Trường ảnh phải là ảnh.',
            'avatar.mimes' => 'Trường ảnh phải có định dạng jpeg,png,jpg,gif,svg.',

        ];
    }
}
