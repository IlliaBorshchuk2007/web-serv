<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|min:3|max:200',
            'slug' => 'max:200',
            'description' => 'nullable|string|max:500|min:3',
            'parent_id' => 'nullable|integer|exists:blog_categories,id',
            'is_published' => 'nullable|boolean',  // ← додай
        ];
    }
}
