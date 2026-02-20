<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $imageConfig = config('imagesetting.default.article');
        
        return [
            'name'=>'required|string',
            'slug'=>'required|string|unique:articles,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            'description'=>'required|string',
            'about'=>'required|string',
            'min_read'=>'required|integer',
            'display_order'=>'required|integer',
            'type'=>'required|string|in:article,story',
            'image' => 'required|image|mimes:' . $imageConfig['mime_types'] . '|max:' . $imageConfig['max_size'],
            'status'=>'boolean',
            ];
    }
}
