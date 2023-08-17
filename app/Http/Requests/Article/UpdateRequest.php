<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\MetaSeo;

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
        $metaseo = MetaSeo::where('article_id', $this->id)
                        ->where('options', 'article')
                        ->first();
        return [
            "title" => "required",
            "detail" => "required",
            "category_id" => "required",
            "posting_date" => "required",
            "posting_by" => "required",
            "status" => "required",
            "title_tag" => "required",
            "meta_desc" => "required",
            'url_slug' => [
                'required',
                Rule::unique('meta_seo', 'url_slug')->ignore($metaseo->id),
                'string'
            ],
            "canonical" => "required|url",
            "meta_key" => "required",
        ];
    }

    public function message()
    {   
        return [
            "title.required" => "Title field is required.",
            "detail.required" => "Detail field is required.",
            "category_id.required" => "Category field is required.",
            "posting_date.required" => "Posting Date field is required.",
            "posting_by.required" => "Posting By field is required.",
            "status.required" => "Status field is required.",
            "title_tag.required" => "Title Tag is required.",
            "meta_desc.required" => "Meta Description field is required.",
            "url_slug.required" => "URL field is required.",
            "canonical.required" => "Canonical field is required.",
            "meta_key.required" => "Meta Keyword field is required."
        ];
    }
}
