<?php

namespace App\Http\Requests;

use App\Providers\EmptyWithValidator;
use Illuminate\Foundation\Http\FormRequest;

class ContentRequest extends FormRequest
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
            'content_images' => 'required_with:content_video',
//            'content_video' => 'required_without:content_images',
//            'content_video' => 'empty_with:content_images',
        ];
    }
}
