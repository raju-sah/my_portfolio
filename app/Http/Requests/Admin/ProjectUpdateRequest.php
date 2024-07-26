<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProjectUpdateRequest extends FormRequest
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
            'slug' => "required|string|unique:projects,slug,{$this->project->id} |regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/",
            'tech_used.*' => 'required|string',
            'web_url' => 'nullable|string',
            'github_url' => 'nullable|string',
            'year' => 'required|string',
            'display_order' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:' . $imageConfig['mime_types'] . '|max:' . $imageConfig['max_size'],
            'status' => 'boolean',
        ];
    }
}
