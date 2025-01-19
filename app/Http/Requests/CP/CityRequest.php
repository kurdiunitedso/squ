<?php

namespace App\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust authorization logic if needed
    }

    public function rules()
    {
        $pattern = '/^[a-zA-Z' . mb_convert_encoding('&#x0600;-' . '&#x06FF;', 'UTF-8', 'HTML-ENTITIES') . '\s]+$/';
        $rules = [];
        foreach (config('app.locales') as $locale) {
            $rules["name.$locale"] = 'required|string|max:255';
        }
        return [
            // 'name_en' => [
            //     'required',
            //     // 'regex:' . $pattern,
            // ],
            // 'name_ar' => [
            //     'required',
            //     // 'regex:' . $pattern,
            // ],
            'country_id' => 'required|exists:countries,id',
        ];
    }

    public function messages()
    {
        return [
            'name_en.regex' => t('The English name must only contain valid characters.'),
            'name_ar.regex' => t('The Arabic name must only contain valid characters.'),
            'country_id.required' => t('Country ID is required.'),
            'country_id.exists' => t('The selected Country ID is invalid.'),
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->has('name_en') && !$this->has('name_ar')) {
            $this->merge([
                'name_en' => '',
                'name_ar' => '',
            ]);
        }
    }
}
