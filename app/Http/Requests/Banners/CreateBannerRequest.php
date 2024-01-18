<?php

namespace App\Http\Requests\Banners;

use Illuminate\Foundation\Http\FormRequest;

class CreateBannerRequest extends FormRequest
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
            'title' => 'required|max:255',
            'image' => 'required|image',
            'description' => 'required',
            'link' => 'required',
            'status' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Trường tên là bắt buộc.',
            'image.required' => 'Trường ảnh là bắt buộc.',
            'image.image' => 'Trường ảnh không đúng định dạng.',
            'description.required' => 'Trường mô tả là bắt buộc.',
            'link.required' => 'Trường link là bắt buộc.',
            'status.required' => 'Trường trạng thái là bắt buộc.',
        ];
    }
}
