<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HomeSettingUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

   
    public function rules(): array
    {
        $imageConfig = config('imagesetting.default.image');
        return [
            'title' => 'required|string',
            'slug' => "required|string|unique:home_settings,slug,{$this->home_setting->id},id|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/",
            'logo' => 'nullable|image|mimes:' . $imageConfig['mime_types'] . '|max:' . $imageConfig['max_size'],
            'image' => 'nullable|image|mimes:' . $imageConfig['mime_types'] . '|max:' . $imageConfig['max_size'],
            'description' => 'nullable|string',
            'status' => 'boolean',
            'name.*' => 'nullable|string',

        ];
    }
}
