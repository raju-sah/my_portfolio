<?php

namespace App\Http\Requests\Admin;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class ReviewStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'description' => 'required|string',
            'rating' => 'required|integer',
            'article_id' => 'required|integer',
            'g-recaptcha-response' => ['required', new Recaptcha()],
        ];
    }
}
