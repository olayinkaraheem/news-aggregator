<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPreferenceRequest extends FormRequest
{
   /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sources' => 'nullable|array',
            'sources.*' => 'string|exists:news_aggregates,source',
            'authors' => 'nullable|array',
            'authors.*' => 'string|exists:news_aggregates,author',
            'categories' => 'nullable|array',
            'categories.*' => 'string|exists:news_aggregates,category',
        ];
    }
}
