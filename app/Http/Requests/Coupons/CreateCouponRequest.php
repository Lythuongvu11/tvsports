<?php

namespace App\Http\Requests\Coupons;

use Illuminate\Foundation\Http\FormRequest;

class CreateCouponRequest extends FormRequest
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
            'name' => 'required|max:255|unique:coupons,name',
            'value' => 'required|numeric|min:0',
            'type' => 'required',
            'expery_date' => 'required|date|after_or_equal:today',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên mã giảm giá không được để trống',
            'name.max' => 'Tên mã giảm giá không được vượt quá 255 ký tự',
            'name.unique' => 'Tên mã giảm giá đã tồn tại',
            'value.required' => 'Giá trị giảm giá không được để trống',
            'value.numeric' => 'Giá trị giảm giá phải là số',
            'value.min' => 'Giá trị giảm giá phải lớn hơn 0',
            'type.required' => 'Kiểu giảm giá không được để trống',
            'expery_date.required' => 'Ngày hết hạn không được để trống',
            'expery_date.date' => 'Ngày hết hạn không hợp lệ',
            'expery_date.after_or_equal' => 'Ngày hết hạn phải lớn hơn hoặc bằng ngày hiện tại',
        ];
    }
}
