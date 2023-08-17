<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'company_name' => ['required', 'string'],
            'company_description' => ['required', 'string'],
            'company_copyright' => ['required', 'string'],
            'company_logo' => ['nullable', 'max:2000', 'file', 'mimes:jpeg,jpg,png,gif,JPG,PNG,GIF,JPEG'],
            'company_favicon' => ['nullable', 'max:2000', 'file', 'mimes:jpeg,jpg,png,gif,ico,JPG,PNG,GIF,JPEG,ICO'],
        ];
    }
}
