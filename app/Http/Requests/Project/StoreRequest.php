<?php

namespace App\Http\Requests\Project;

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
            "title" => "required",
            "main_image" => "required",
            "detail" => "required",
            "category_id" => "required",
            "posting_date" => "required",
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
            "title.required" => "Title field is required.",
            "main_image.required" => "Main Image field is required.",
            "detail.required" => "Detail field is required.",
            "category_id.required" => "Category field is required.",
            "posting_date.required" => "Posting Date field is required.",
            "status.required" => "Status field is required.",
            "title_tag.required" => "Title Tag is required.",
            "meta_desc.required" => "Meta Description field is required.",
            "url_slug.required" => "URL field is required.",
            "canonical.required" => "Canonical field is required.",
            "meta_key.required" => "Meta Keyword field is required."
        ];
    }
}
