<?php

namespace App\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust authorization logic if needed
    }

    public function rules()
    {
        $pattern = '/^[a-zA-Z' . mb_convert_encoding('&#x0600;-' . '&#x06FF;', 'UTF-8', 'HTML-ENTITIES') . '\s]+$/';

        $isEdit = $this->has('country_id'); // Checking if 'country_id' exists means it's an edit request
        $rules = [];
        foreach (config('app.locales') as $locale) {
            $rules["name.$locale"] = 'required|string|max:255';
        }

        $rules += [

            'code' => [
                'required',
                'string',
                'max:2',
                $isEdit ? 'sometimes' : 'unique:countries', // Check for uniqueness conditionally
            ],
            // 'country_icon' => $isEdit ? 'sometimes|nullable|image|mimes:jpg,jpeg,png,svg' : 'nullable|image|mimes:jpg,jpeg,png,svg',
        ];
        if (request()->country_icon != 'undefined') {
            $rules += [
                'country_icon' => [
                    $isEdit ? 'nullable' : 'required',
                    'image',
                    'mimes:jpg,jpeg,png,svg',
                ],

            ];
        }

        return $rules;
    }

    public function messages()
    {
        return  [
            'name_ar.required' => t('The country Arabic name is required.'),
            'name_en.required' => t('The country English name is required.'),
            'name_ar.regex' => t('The country name must only contain letters and spaces.'),

            'code.required' => t('The country code is required.'),
            'code.string' => t('The country code must be a string.'),
            'code.max' => t('The country code may not be greater than 2 characters.'),
            'code.unique' => t('The country code has already been taken.'),

            'country_icon.required' => t('The country icon is required.'),
            'country_icon.image' => t('The country icon must be an image.'),
            'country_icon.mimes' => t('The country icon must be a file of type: jpg, jpeg, png, svg.'),
        ];
    }
}
