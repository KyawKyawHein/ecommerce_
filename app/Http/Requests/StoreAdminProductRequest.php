<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminProductRequest extends FormRequest
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
            "name" =>['required','unique:users,name'],
            "description"=>['required'],
            'price'=>['required','integer'],
            'stock_quantity'=>['required','integer'],
            'category_id'=>['required','exists:categories,id'],
            'image'=>['required','mimes:png,jpg,jpeg']
        ];
    }
}
