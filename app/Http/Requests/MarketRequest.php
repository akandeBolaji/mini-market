<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name.required' => 'Name is required!',
            'description.required' => 'Description is required!',
            'category.required' => 'Category is required',
            "images"    => "required|array|min:3|max:3",
            'images.*' => 'required|mimetypes:image/jpeg,image/png,image/bmp|max:2000',
            'images.required' => 'Please upload one or more images',
            'images.max' => 'A maximum of three images are allowed',
            'images.max' => 'A minimum of three images are allowed',
            'images.*.mimetypes' => 'Only jpeg,png and bmp images are allowed',
            'images.*.max' => 'Sorry! Maximum allowed size for an image is 2MB',
        ];
    }
}
