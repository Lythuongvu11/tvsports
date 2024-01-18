<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|max:255',
            'description' => 'required',
            'sale' => 'required|numeric',
            'price' => 'required|numeric',
            'category_ids' => 'required',
            'size' => 'required',
            'quantity' => 'required|numeric',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Trường tên là bắt buộc.',
            'description.required' => 'Trường mô tả là bắt buộc.',
            'sale.required' => 'Trường giảm giá là bắt buộc.',
            'sale.numeric' => 'Trường giảm giá phải là số.',
            'price.required' => 'Trường giá là bắt buộc.',
            'price.numeric' => 'Trường giá phải là số.',
            'category_ids.required' => 'Trường danh mục là bắt buộc.',
            'size.required' => 'Trường kích thước là bắt buộc.',
            'quantity.required' => 'Trường số lượng là bắt buộc.',
            'quantity.numeric' => 'Trường số lượng phải là số.',
        ];
    }
}
