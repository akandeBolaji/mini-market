<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMarketRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
            'address' => 'required',
            'address_lat' => 'required',
            'address_long' => 'required',
            'images.max' => 'A maximum of three images are allowed',
            'images.max' => 'A minimum of three images are allowed',
            'images.*.mimetypes' => 'Only jpeg,png and bmp images are allowed',
            'images.*.max' => 'Sorry! Maximum allowed size for an image is 2MB',
        ];
    }
}
