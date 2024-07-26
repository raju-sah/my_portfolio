<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
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
            'email' => 'required|email',
            'image' => 'nullable|image|mimes:' . $imageConfig['mime_types'] . '|max:' . $imageConfig['max_size'],
            'position' => 'required|string',
            'phone' => 'nullable|string',
            'facebook_link' => 'nullable|string',
            'instagram_link' => 'nullable|string',
            'linkedin_link' => 'nullable|string',
            'website_link' => 'nullable|string',
            'github_link' => 'nullable|string',
            'message' => 'nullable|string',
            'status' => 'boolean',
        ];
    }
}
