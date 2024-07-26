<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SocialSettingUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'facebook_url' => 'required|string',
            'insta_url' => 'required|string',
            'twitter_url' => 'nullable|string',
            'youtube_url' => 'nullable|string',
            'linkedin_url' => 'required|string',
            'github_url' => 'required|string',
        ];
    }
}
