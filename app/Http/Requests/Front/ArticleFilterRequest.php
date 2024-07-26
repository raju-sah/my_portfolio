<?php

namespace App\Http\Requests\Front;

use App\Enums\AscDescFilterType;
use App\Enums\CommonFilterType;
use App\Enums\PaginationFilterType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ArticleFilterRequest extends FormRequest
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
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'common_filter' => ['nullable', new Enum(CommonFilterType::class)],
            'asc_desc_filter' => [new Enum(AscDescFilterType::class)],
            'pagination_filter' => [new Enum(PaginationFilterType::class)],
        ];
    }
}
