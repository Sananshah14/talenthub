<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       return [
        'company_name' => ['required', 'string', 'max:150'],
        'job_title' => ['required', 'string', 'max:150'],

        'start_date' => ['required', 'date'],
        'end_date' => [
            'nullable',
            'date',
            'after_or_equal:start_date',
        ],

        'currently_working' => ['required', 'boolean'],

        'location' => ['nullable', 'string', 'max:150'],

        'description' => ['nullable', 'string'],
    ];
    }
}
