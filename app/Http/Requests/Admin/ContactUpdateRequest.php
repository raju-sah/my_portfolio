<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name'=>'required|string',
            'email'=>'required|email',
            'phone' => 'required|regex:/^[0-9\-+]+$/|min:10',
            'message'=>'required|string|min:5',
            ];
    }
}
