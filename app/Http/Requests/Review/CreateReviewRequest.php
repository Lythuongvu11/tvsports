<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest
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
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'rating.required' => 'Bạn chưa đánh giá',
            'rating.numeric' => 'Đánh giá phải là số',
            'rating.min' => 'Đánh giá phải lớn hơn 0',
            'rating.max' => 'Đánh giá phải nhỏ hơn 5',
            'comment.required' => 'Bạn chưa nhập bình luận',
        ];
    }
}
