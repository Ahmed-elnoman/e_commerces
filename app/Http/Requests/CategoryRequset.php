<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequset extends FormRequest
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
            'category_name'                 => ['required', 'string'],
            'category_file'                 => ['image', 'mimes:jpeg,png,jpg,gif,webp'],
            'category_description'          => 'required',
            'category_meta_name'            => 'required',
            'category_meta_ketword'         => 'required',
            'category_meta_description'     => 'required',

        ];
    }
}