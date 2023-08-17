<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "images" => "required",
            "product_name" => "required",
            "product_description" => "required",
            "category_id" => "required",
            "status" => "required",
            "title_tag" => "required",
            "meta_desc" => "required",
            "url_slug" => ['required', 'unique:meta_seo,url_slug'],
            "canonical" => "required|url",
            "meta_key" => "required",
        ];
    }

    public function message()
    {   
        return [
            "images.required" => "Field is required.",
            "product_name.required" => "Field is required.",
            "product_description.required" => "Field is required.",
            "category_id.required" => "Field is required.",
            "status.required" => "Field is required.",
            "title_tag.required" => "Title Tag is required.",
            "meta_desc.required" => "Meta Description field is required.",
            "url_slug.required" => "URL field is required.",
            "canonical.required" => "Canonical field is required.",
            "meta_key.required" => "Meta Keyword field is required."
        ];
    }
}
