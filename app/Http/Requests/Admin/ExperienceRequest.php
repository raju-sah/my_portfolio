<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends FormRequest
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
            'slug' => "required|string|unique:experiences,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/",
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:' . $imageConfig['mime_types'] . '|max:' . $imageConfig['max_size'],
            'location' => 'nullable|string',
            'web_url' => 'required|string',
            'role' => 'required|string',
            'display_order' => 'required|numeric',
            'date_from' => 'required|string',
            'date_to' => 'nullable|string',
            'status' => 'boolean',
            'currently_here' => 'boolean',
            'tags' => 'nullable|array',
        ];
    }
}
