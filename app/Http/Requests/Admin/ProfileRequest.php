<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $imageConfig = config('imagesetting.default.image');
        
        return [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:' . $imageConfig['mime_types'] . '|max:' . $imageConfig['max_size'],
            'current_password' => 'nullable|string|required_with:new_password|min:8',
            'new_password' => 'nullable|string|min:8',
            'confirm_password' => 'nullable|string|same:new_password',
        ];

    }
}
