<?php

namespace App\Http\Requests\CP;

use App\Models\Constant;
use App\Models\WebsiteSection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class WebsiteSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can(WebsiteSection::ui['s_lcf'] . '_access');
    }

    public function rules(): array
    {
        Log::info(self::class . ' validation rules starting', [
            'method' => $this->method(),
            WebsiteSection::ui['_id'] => $this->id,
        ]);

        $rules = [
            'name' => ['required', 'array'],
            'description' => ['nullable', 'array'],
            'type_id' => ['required', 'exists:' . Constant::ui['table'] . ',id'],
            'attachment_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'active' => ['boolean'],
            'order' => ['integer'],
            'url' => ['nullable'],
        ];

        // Add validation rules for each locale
        foreach (config('app.locales') as $locale) {
            $rules["name.$locale"] = ['required', 'string', 'max:255'];
            $rules["description.$locale"] = ['nullable', 'string', 'max:1000'];
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'name.required' => t('The section name is required'),
            'name.array' => t('The section name must be translatable'),

            'description.array' => t('The section description must be translatable'),

            'type_id.required' => t('Type is required'),
            'type_id.exists' => t('Selected type is invalid'),

            'attachment_file.image' => t('The file must be an image'),
            'attachment_file.mimes' => t('The image must be a file of type: jpeg, png, jpg, gif'),
            'attachment_file.max' => t('The image must not be larger than 2MB'),

            'active.boolean' => t('Status must be true or false'),
        ];

        // Add translation messages for each locale
        foreach (config('app.locales') as $locale) {
            $messages["name.$locale.required"] = t(
                'The section name in :locale is required',
                ['locale' => strtoupper($locale)]
            );
            $messages["name.$locale.max"] = t(
                'The section name in :locale cannot exceed :max characters',
                ['locale' => strtoupper($locale), 'max' => 255]
            );

            $messages["description.$locale.max"] = t(
                'The section description in :locale cannot exceed :max characters',
                ['locale' => strtoupper($locale), 'max' => 1000]
            );
        }

        return $messages;
    }

    protected function prepareForValidation(): void
    {
        // Trim string inputs
        $inputs = $this->all();

        if (isset($inputs['name'])) {
            foreach ($inputs['name'] as $locale => $value) {
                $inputs['name'][$locale] = trim($value);
            }
        }

        if (isset($inputs['description'])) {
            foreach ($inputs['description'] as $locale => $value) {
                $inputs['description'][$locale] = $value ? trim($value) : null;
            }
        }

        // Convert active to boolean if present
        if (isset($inputs['active'])) {
            $inputs['active'] = filter_var($inputs['active'], FILTER_VALIDATE_BOOLEAN);
        }

        $this->merge($inputs);
    }

    protected function passedValidation(): void
    {
        Log::info('WebsiteSection validation passed', [
            'validated_data' => $this->validated(),
            'translations' => [
                'name' => $this->input('name'),
                'description' => $this->input('description')
            ]
        ]);
    }
}
