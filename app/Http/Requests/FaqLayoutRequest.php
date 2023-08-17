<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqLayoutRequest extends FormRequest
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
            "captions" => "required",
            "title_tag" => "required",
            "meta_desc" => "required",
            "url_slug" => "required",
            "canonical" => "required|url",
            "meta_key" => "required",
        ];
    }

    public function message()
    {   
        return [
            "title.required" => "Title field is required.",
            "captions.required" => "Captions field is required.",
            "title_tag.required" => "Title Tag is required.",
            "meta_desc.required" => "Meta Description field is required.",
            "url_slug.required" => "URL field is required.",
            "canonical.required" => "Canonical field is required.",
            "meta_key.required" => "Meta Keyword field is required."
        ];
    }
}
