<?php

namespace App\Http\Requests\Admin;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
                'name'=>'required|string',
                'email'=>'required|email',
                'phone' => 'nullable|regex:/^\s*[0-9\-+\s]*\s*$/|min:10',
                'message'=>'required|string|min:5',
                'g-recaptcha-response' => ['required', new Recaptcha()],

            ];
    }
}
