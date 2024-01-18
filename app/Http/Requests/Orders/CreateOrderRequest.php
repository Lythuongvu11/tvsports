<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'customer_phone' => 'required',
            'customer_address' => 'required',
            'note' => 'nullable',

        ];
    }
    public function messages(): array
    {
        return [
            'customer_name.required' => 'Tên khách hàng không được để trống',
            'customer_email.required' => 'Email không được để trống',
            'customer_email.email' => 'Email không đúng định dạng',
            'customer_phone.required' => 'Số điện thoại không được để trống',
            'customer_address.required' => 'Địa chỉ không được để trống',
        ];
    }
}
