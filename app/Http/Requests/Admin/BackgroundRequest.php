<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BackgroundRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $imageConfig = config('imagesetting.default.image');
        
        return [
            'name' => 'required|string',
            'slug' => "required|string|unique:backgrounds,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/",
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:' . $imageConfig['mime_types'] . '|max:' . $imageConfig['max_size'],
            'address' => 'nullable|string',
            'web_url' => 'nullable|string',
            'map_url' => 'nullable|string',
            'status' => 'boolean',
        ];
    }
}
