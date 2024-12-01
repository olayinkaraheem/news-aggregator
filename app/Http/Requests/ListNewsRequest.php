<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListNewsRequest extends FormRequest
{
   /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'keyword' => 'nullable|string',
            'category' => 'nullable|string',
            'source' => 'nullable|string',
            'date' => 'nullable|date_format:Y-m-d',
        ];
    }
}
