<?php

namespace App\Http\Requests\CP\Program;

use App\Models\Program;
use App\Models\ProgramPage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgramPageRequestQuestion extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $locales = config('app.locales');

        $rules = [
            'question' => 'required|array',
            'type' => 'required|string',
            'score' => 'nullable|numeric|min:0',
            'order' => 'required|integer|min:0',
            'required' => 'nullable|boolean',
            ProgramPage::ui['_id'] => 'required|exists:' . ProgramPage::ui['table'] . ',id',

        ];

        // Add translation rules for each locale
        foreach ($locales as $locale) {
            $rules["question.$locale"] = 'required|string';
        }

        // Add validation for options when type requires them
        $rules['options'] = 'required_if:type,multiple_choice,single_choice|array';
        $rules['options.*.en'] = 'required_if:type,multiple_choice,single_choice|string';
        $rules['options.*.ar'] = 'required_if:type,multiple_choice,single_choice|string';

        return $rules;
    }

    public function messages()
    {
        return [
            'question.*.required' => 'The question field is required for :attribute language.',
            'options.*.en.required_if' => 'The option in English is required when type is multiple choice or single choice.',
            'options.*.ar.required_if' => 'The option in Arabic is required when type is multiple choice or single choice.',
        ];
    }
}
