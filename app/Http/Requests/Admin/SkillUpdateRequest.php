<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SkillUpdateRequest extends FormRequest
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
            'slug' => "required|string|unique:skills,slug,{$this->skill->id}|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/",
            'percentage' => 'required|integer|min:0|max:100',
            'display_order' => 'nullable|integer',
            'description' => 'nullable|string',
            'skill_domain' => ['required', new \Illuminate\Validation\Rules\Enum(\App\Enums\SkillDomain::class)],
            'status' => 'boolean',
        ];
    }
}
