<?php
// app/Helpers/FormHelper.php

namespace App\helper;

class FormHelper
{
    private $prefix;
    private $model;

    public function __construct($prefix = '', $model = null)
    {
        $this->prefix = $prefix;
        $this->model = $model;
    }

    /**
     * Get field name with optional prefix
     */
    public function name($fieldName)
    {
        return $this->prefix ? "{$this->prefix}_{$fieldName}" : $fieldName;
    }

    /**
     * Get old value for a field considering prefix and translations
     */
    public function value($fieldName)
    {
        $prefixedName = $this->name($fieldName);

        // Check if it's a translatable field (contains [locale])
        if (preg_match('/^(.+)\[([^]]+)\]$/', $fieldName, $matches)) {
            $field = $matches[1];
            $locale = $matches[2];

            // If we have a model, get translations
            if ($this->model && method_exists($this->model, 'getTranslations')) {
                $translations = $this->model->getTranslations()[$field] ?? [];
                $modelValue = $translations[$locale] ?? '';
            } else {
                $modelValue = '';
            }

            return old("{$prefixedName}.$locale", $modelValue);
        }

        // Regular non-translatable field
        return old($prefixedName, $this->model->{$fieldName} ?? '');
    }

    /**
     * Get error state class for a field
     */
    public function errorClass($fieldName, $baseClass = '')
    {
        $prefixedName = $this->name($fieldName);
        return $baseClass . ' ' . ($errors->has($prefixedName) ? 'is-invalid' : '');
    }

    /**
     * Create a new instance with given prefix and model
     */
    public static function make($prefix = '', $model = null)
    {
        return new static($prefix, $model);
    }
}
