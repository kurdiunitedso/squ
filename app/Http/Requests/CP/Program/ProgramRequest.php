<?php

namespace App\Http\Requests\CP\Program;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgramRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true; //auth()->user()->can('user_access');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'array'],
        ];
    }

    public function messages(): array
    {
        $messages = [
            'name.*.required' => t('Name is required'),
        ];

        foreach (config('app.locales') as $locale) {
            $messages["name.$locale.required"] = t('Name in :locale is required', ['locale' => strtoupper($locale)]);
        }

        return $messages;
    }
}
