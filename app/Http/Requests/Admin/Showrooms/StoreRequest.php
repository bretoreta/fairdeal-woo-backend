<?php

namespace App\Http\Requests\Admin\Showrooms;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'google_review_link' => ['required', 'string', 'url'],
            'phone' => ['required', 'string', 'starts_with:254', 'max:12', 'unique:showrooms'],
        ];
    }
}
