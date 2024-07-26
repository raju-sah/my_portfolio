<?php

namespace App\Http\Requests\Admin;

use App\Enums\VisitorType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class DimensionFilterRequest extends FormRequest
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
        return [
            'country' => 'nullable|string',
            'city' => 'nullable|string',
            'operatingSystem' => 'nullable|string',
            'deviceCategory' => 'nullable|string',
            'firstUserSource' => 'nullable|string',
            'pageTitle' => 'nullable|string',
            'newVsReturning' => ['nullable', new Enum(VisitorType::class)],
            'from_date' => 'nullable|date_format:Y-m-d',
            'to_date' => 'nullable|date_format:Y-m-d',
            'paginate' => 'nullable',
        ];
    }
}
