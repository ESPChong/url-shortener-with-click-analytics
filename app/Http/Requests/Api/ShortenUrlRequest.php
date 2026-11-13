<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ShortenUrlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Route-level auth:sanctum already guarantees a token holder.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'url' => ['required', 'url'],
            'custom_alias' => ['nullable', 'string', 'min:3', 'max:32', 'alpha_dash', 'unique:urls,short_url'],
        ];
    }
}
